<?php

namespace App\Console\Commands;

use App\Employee;
use App\Department;
use Carbon\Carbon;
use Illuminate\Console\Command;

class LdapSync extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mis:ldapsync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '(MIS-EWS) Synchronize employee data from ldap.1and1.com to local.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $ldap_host = "ldap.1and1.com";
        $ldap_dn = "uid=uk_usersync, uid=passauth, uid=portal, ou=Tools,o=1und1,c=DE";
        $ldap_pass = "inselaffe";

        // Initializing LDAP connection.
        $this->info('Initializing LDAP connection...');
        $ldap_conn = ldap_connect($ldap_host) or exit("Cannot connect to LDAP server \n");
        ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_bind($ldap_conn, $ldap_dn, $ldap_pass) or exit("Failed to bind to ldap server \n");

        // Initializing employee ldap filters
        $dn = "ou=People,ou=portal,o=1und1,c=DE";
        $filter = "(&(ObjectClass=spPerson)(|(locationid=21191176)(locationid=21248890)(locationid=21193071)(locationid=21229681)(locationid=21251607)(locationid=21201736)(locationid=21447235)(locationid=5012394)(locationid=21436849)(locationid=21445205)(locationid=21423046))(uid=*))";
        $result = array("personid", "uid", "userPassword", "sn", "givenName", "mail", "departmentNumber", "ou", "locationid");
        $emp_search = ldap_search($ldap_conn, $dn, $filter, $result);
        $emp_data = ldap_get_entries($ldap_conn, $emp_search);

        $autoDomain = array();
        $emp_users = array();
        $active_users = array();
        $added_users = 0;
        $inactive_users = 0;

        for ($i = 0; $i < count($emp_data) - 1; $i++) {
            $emp = Employee::find($emp_data[$i]['personid'][0]);
            $_pass = isset($emp_data[$i]['userpassword'][0]) ? $emp_data[$i]['userpassword'][0] : '';
            $_email = isset($emp_data[$i]['mail']) ? $emp_data[$i]['mail'][0] : '';
            
            if($emp) {
                $ctr = 0;
                if($emp->password != $_pass) {
                    $this->info(sprintf("Password for user %s was updated.", $emp_data[$i]['uid'][0]));
                    $emp->password = $_pass;
                    $ctr++;
                }
                if($emp->fname != $emp_data[$i]['givenname'][0]) {
                    $this->info(sprintf("First name was updated from %s to %s", $emp->fname, $emp_data[$i]['givenname'][0]));
                    $emp->fname = $emp_data[$i]['givenname'][0];
                    $ctr++;
                }
                if($emp->lname != $emp_data[$i]['sn'][0]) {
                    $this->info(sprintf("Last name was updated from %s to %s", $emp->lname, $emp_data[$i]['sn'][0]));
                    $emp->lname = $emp_data[$i]['sn'][0];
                    $ctr++;
                }
                if($_email && $emp->email != $_email) {
                    $this->info(sprintf("Email address was updated from %s to %s", $emp->email, $emp_data[$i]['mail'][0]));
                    $emp->email = $emp_data[$i]['mail'][0];
                    $ctr++;
                }
                if($emp->departmentid != $emp_data[$i]['departmentnumber'][0]) {
                    $this->info(sprintf("DepartmentID was updated from %s to %s", $emp->departmentid, $emp_data[$i]['departmentnumber'][0]));
                    $emp->departmentid = $emp_data[$i]['departmentnumber'][0];
                    $ctr++;
                }

                if($emp->locationid != $emp_data[$i]['locationid'][0]) {
                    $emp->locationid = $emp_data[$i]['locationid'][0];
                    $ctr++;
                }
                
                if($ctr > 0) $emp->save();
                
            } else {
                $emp_new = new Employee;
                $emp_new->uid = $emp_data[$i]['personid'][0];
                $emp_new->username = $emp_data[$i]['uid'][0];
                $emp_new->password = $_pass;
                $emp_new->departmentid = $emp_data[$i]['departmentnumber'][0];
                $emp_new->fname = $emp_data[$i]['givenname'][0];
                $emp_new->lname = $emp_data[$i]['sn'][0];
                $emp_new->email = $_email;
                $emp_new->locationid = $emp_data[$i]['locationid'][0];
                $emp_new->active = 1;
                $emp_new->save();
                
                $this->info('Added new employee: ' . $emp_data[$i]['uid'][0]);
                $added_users++;
            }

            $emp_users[$emp_data[$i]['uid'][0]] = $emp_data[$i]['personid'][0];
            $autoDomain[$emp_data[$i]['departmentnumber'][0]] = $emp_data[$i]['ou'][0];

            $active_users[] = $emp_data[$i]['personid'][0];
        }

        $dn1 = "ou=Groups,ou=portal,o=1und1,c=DE";
        $result1 = array("uid", "admin", "ou", "member");

        foreach ($autoDomain as $dept_id => $ou) {
            try {
                $filter1 = "(&(ObjectClass=organizationalunit)(ou=Auto-Domain - $ou))";
                $filter2 = "(&(ObjectClass=organizationalunit)(ou=Auto-Direct Reporter - $ou))";
                $grp1_search = ldap_search($ldap_conn, $dn1, $filter1, $result1);
                $grp1_data = ldap_get_entries($ldap_conn, $grp1_search);
                $grp2_search = ldap_search($ldap_conn, $dn1, $filter2, $result1);
                $grp2_data = ldap_get_entries($ldap_conn, $grp2_search);

                // Checking admin & members for OU
                for ($i = 0; $i < count($grp1_data) - 1; $i++) {
                    $_admin = $this->get_uid($emp_users, $grp1_data[$i]['admin'][0]);
                    $_dreporters = $this->get_uid($emp_users, $grp2_data[$i]['member'], $grp2_data[$i]['admin'][0]);
                    $_members = $this->get_uid($emp_users, $grp1_data[$i]['member'], $grp1_data[$i]['admin'][0]);
                    $department = Department::find($grp1_data[$i]['uid'][0]);

                    if ($department) {
                        $ctr = 0;
                        if ($department->admin != $_admin) {
                            $this->info(sprintf("Updated admin for %s from %s to %s.", $department->name, $department->admin, $_admin));
                            $department->admin = $_admin;
                            $ctr++;
                        }
                        if ($department->name != $ou) {
                            $this->info(sprintf("Updated department name from %s to %s.", $department->name, $ou));
                            $department->name = $ou;
                            $ctr++;
                        }
                        if (strcmp($department->directreports->lists('uid')->tojson(), $_dreporters) != 0) {
                            $this->info(sprintf("Updated direct-reporters for %s.", $ou));
                            $department->direct_reporters = $_dreporters;
                            $ctr++;
                        }
                        if (strcmp($department->members->lists('uid')->tojson(), $_members) != 0) {
                            $this->info(sprintf("Updated members for %s.", $ou));
                            $department->members = $_members;
                            $ctr++;
                        }

                        if ($ctr > 0)
                            $department->save();
                    } else {
                        $dept_new = new Department;
                        $dept_new->gid = $grp1_data[$i]['uid'][0];
                        $dept_new->departmentid = $dept_id;
                        $dept_new->name = $ou;
                        $dept_new->admin = $_admin;
                        $dept_new->direct_reporters = $_dreporters;
                        $dept_new->members = $_members;
                        $dept_new->save();

                        $this->info('Added new group: ' . $ou);
                    }
                }
            } catch (\Exception $ex) {
                $this->error($ex->getMessage());
            }
        }

        $db_inusers = \DB::table('employees')->where('active', 1)->get();
        foreach ($db_inusers as $row) {
            if (!in_array($row->uid, $active_users)) {
                \DB::table('employees')
                        ->where('uid', $row->uid)
                        ->update([
                            'active' => 0,
                            'updated_at' => Carbon::now()]);
                $this->info(sprintf("Setting user %s to inactive.", $row->username));
                $inactive_users++;
            }
        }

        $db_acusers = \DB::table('employees')->where('active', 0)->get();
        $reactive_users = 0;
        foreach ($db_acusers as $row) {
            if (in_array($row->uid, $active_users)) {
                \DB::table('employees')
                        ->where('uid', $row->uid)
                        ->update([
                            'active' => 1,
                            'updated_at' => Carbon::now()]);
                $this->info(sprintf("Reactivate user %s who where previously inactive.", $row->username));
                $reactive_users++;
            }
        }

        $this->info('Setting default employee roles...');
        \DB::table('employees')->where('roles', "")->update(['roles' => 'agent']);
        \DB::table('employees')->join('departments', 'employees.uid', '=', 'departments.admin')
                ->update(['employees.roles' => 'supervisor']);
        \DB::table('employees')->where('roles', '!=', 'manager')
                ->whereIn('username', ['jay', 'aangon', 'jgarcia', 'kamparado', 'jalcarz', 'kdominguez', 'epulido'])
                ->update(['roles' => 'manager', 'updated_at' => Carbon::now()]);
        \DB::table('employees')->where('roles', '!=', 'som')
                ->whereIn('username', ['aandrino', 'nparilla', 'csabinay', 'lnavarrete'])
                ->update(['roles' => 'som', 'updated_at' => Carbon::now()]);
        \DB::table('employees')->whereIn('departmentid', [21395000, 21437605])
                ->update(['roles' => 'sas', 'updated_at' => Carbon::now()]);
        \DB::table('employees')->where('departmentid', 21238070)
                ->update(['roles' => 'it', 'updated_at' => Carbon::now()]);
        \DB::table('employees')->whereIn('departmentid', [21241195])
                ->update(['roles' => 'st', 'updated_at' => Carbon::now()]);
        \DB::table('employees')->whereIn('departmentid', [21230629, 21223708])
                ->update(['roles' => 'l2', 'updated_at' => Carbon::now()]);
        $this->info('Setting default market tags on departments...');
        \DB::table('departments')
                ->where([['market', '!=', 'US'], ['name', 'like', 'US %']])
                ->update(['market' => 'US', 'updated_at' => Carbon::now()]);
        \DB::table('departments')
                ->where([['market', '!=', 'UK'], ['name', 'REGEXP', 'UK|FH']])
                ->update(['market' => 'UK', 'updated_at' => Carbon::now()]);

        $this->line("\n");
        $this->info("Number of users found in ldap.1and1.com under locatitionID[21191176] ==> " . $emp_data['count']);
        $this->info("Number of users added in local database ==> $added_users");
        $this->info("Number of users set as inactive in local database ==> $inactive_users");
        $this->info("Number of re-activated users in local database ==> $reactive_users");
    }

    private function get_uid($members, $key, $admin = 0)
    {
        if(is_array($key)) {
            $uids = array();
            foreach($key as $_id) {
                if($_id == $admin) continue;
                $uid = str_replace(",ou=People,ou=portal,o=1und1,c=DE", '', $_id);
                $uid = str_replace("uid=", '', $uid);
                if(isset($members[$uid])) $uids[] = (int)$members[$uid];
            }
            sort($uids);
            return json_encode($uids);
        } else {
            $uid = str_replace(",ou=People,ou=portal,o=1und1,c=DE", '', $key);
            $uid = str_replace("uid=", '', $uid);
            return isset($members[$uid]) ? $members[$uid] : 0;
            //return in_array($uid, ['dh','joetjen','markmueller','eherdt','atraum','rstraeter','msteinberg']) ? 21482062 : $members[$uid];
        }
    }

}
