<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use Session;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $teams;
    private $exemptions;

    public function __construct() {
        $this->middleware('auth');
        if (Auth::check()) {
            $_team = Auth::user()->teams();
            if ($_team->count() == 1 && $_team->first()->departmentid = 21395000)
                $this->teams = \App\Department::where('name', 'like', 'U%')->get();
            else
                $this->teams = $_team;
            $this->exemptions = Auth::user()->settings()->type('filtered_list')->first() ?
                    json_decode(Auth::user()->settings()->type('filtered_list')->first()->entries) : [];
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($wk = false) {
//        $filter_list = [];
//        $filter_selection = [];
//        $name_selection = [];
//        $dash_data = [
//            'calls' => 0, 'emails' => 0,
//            'crr' => 0, 'sas' => 0
//        ];
//        $entries = [];
//        switch (Auth::user()->roles) {
//            case 'SAS':
//            case 'MANAGER':
//            case 'SOM':
//                $filter_selection = $this->teams->lists('name', 'departmentid')->sort();
//                $filter_list = $this->exemptions;
//                $entries = $this->teams->reject(function($value) {
//                    return in_array($value->departmentid, $this->exemptions);
//                });
//                $name_selection = $entries->lists('name', 'departmentid')->sort();
//
//                break;
//            case 'SUPERVISOR':
//            case 'AGENT':
//                if (Auth::user()->roles == 'SUPERVISOR') {
//                    $_entries = Auth::user()->subordinates();
//                    $_entries->push(Auth::user());
//                } else {
//                    $_entries = Auth::user()->superior->subordinates();
//                    $_entries->push(Auth::user()->superior);
//                }
//                $filter_selection = $_entries->lists('lfname', 'uid')->sort();
//                $filter_list = $this->exemptions;
//                $entries = $_entries->reject(function($value) {
//                    return in_array($value->uid, $this->exemptions);
//                });
//        }
//
//        $total_returns = 0;
//        $total_yes = 0;
//        foreach ($entries as $entry) {
//            $dash_data['sas'] += $entry->upsells()->weekly($wk)->valid()->count();
//            $dash_data['calls'] += $entry->cases()->weekly($wk)->calls()->sum('case_count');
//            $dash_data['emails'] += $entry->cases()->weekly($wk)->emails()->sum('case_count');
//            $total_yes += $entry->feedbacks()->weekly($wk)->requestSolved()->count();
//            $total_returns += $entry->feedbacks()->weekly($wk)->count();
//            //$cosmo = $entry->cosmocom()->weekly($wk)->get();
//        }
//        $dash_data['crr'] = $total_returns ? round(($total_yes / $total_returns) * 100, 2) : '';
//
//        $data['dash_data'] = $dash_data;
//        $data['page_title'] = 'Dashboard';
//        $data['page_desc'] = 'Shows data overview for the current week.';
//        $data['filter_selection'] = $filter_selection;
//        $data['filter_list'] = $filter_list;
//        $data['name_selection'] = $name_selection;
//        return view('dashboard', $data);
        
        return redirect("/survey/home");
    }

    public function weeklydata(Request $request) {
        $stats = collect();
        $wk = $request->has('week_selection') ? $request->get('week_selection') : false;
        $entries = [];
        switch (Auth::user()->roles) {
            case 'SAS':
            case 'MANAGER':
            case 'SOM':
                if ($request->has('team_selection')) {
                    if ($request->get('team_selection') == 'all') {
                        $entries = $this->teams->reject(function($value) {
                            return in_array($value->departmentid, $this->exemptions);
                        });
                    } else {
                        $_t = \App\Department::where('departmentid', $request->get('team_selection'))->first();
                        $entries = $_t->members->get();
                        $entries->push($_t->head);
                    }
                } else
                    $entries = $this->teams;
                break;

            case 'SUPERVISOR':
            case 'AGENT':
                if (Auth::user()->roles == 'SUPERVISOR') {
                    $_entries = Auth::user()->subordinates();
                    $_entries->push(Auth::user());
                } else {
                    $_entries = Auth::user()->superior->subordinates();
                    $_entries->push(Auth::user()->superior);
                }
                $entries = $_entries->reject(function($value) {
                    return in_array($value->uid, $this->exemptions);
                });
                break;
        }

        foreach ($entries as $entry) {
            if ($request->has('date_start') && $request->has('date_end')) {
                $start = $request->get('date_start');
                $end = $request->get('date_end');

                $cases = $entry->cases()->dateRange($start, $end)->sum('case_count');
                $calls = $entry->cases()->dateRange($start, $end)->calls()->sum('case_count');
                $emails = $entry->cases()->dateRange($start, $end)->emails()->sum('case_count');
                $blacklist = $entry->cases()->dateRange($start, $end)->blackListed()->sum('case_count');
                $sales = $entry->upsells()->dateRange($start, $end)->valid()->count();
                $returns = $entry->feedbacks()->dateRange($start, $end)->count();
                $yes_count = $entry->feedbacks()->dateRange($start, $end)->requestSolved()->count();
                $cosmo = $entry->cosmocom()->dateRange($start, $end)->get();
            } else {
                $cases = $entry->cases()->weekly($wk)->sum('case_count');
                $calls = $entry->cases()->weekly($wk)->calls()->sum('case_count');
                $emails = $entry->cases()->weekly($wk)->emails()->sum('case_count');
                $blacklist = $entry->cases()->weekly($wk)->blackListed()->sum('case_count');
                $sales = $entry->upsells()->weekly($wk)->valid()->count();
                $returns = $entry->feedbacks()->weekly($wk)->count();
                $yes_count = $entry->feedbacks()->weekly($wk)->requestSolved()->count();
                $cosmo = $entry->cosmocom()->weekly($wk)->get();
            }
            $rdata = [
                $request->get('team_selection') == 'all' ? $entry->name : $entry->lfname,
                $calls,
                $emails,
                $cases,
                $blacklist,
                $cases ? round(($blacklist / $cases) * 100, 2) : 0,
                $returns,
                $yes_count,
                $returns ? round(($yes_count / $returns) * 100, 2) : 0,
                $sales,
                $calls ? round(($sales / $calls) * 100, 2) : 0,
                $cosmo->count() ? round($cosmo->where('state', 'Released')->avg('state_ratio'), 2) : '',
                $cosmo->count() ? round($cosmo->where('state', 'Released')->sum('total_duration'), 2) : '',
                $cosmo->count() ? round($cosmo->where('state', 'Released')->avg('total_duration'), 2) : ''
            ];
            $stats->push($rdata);
        }

        return ['recordsTotal' => $stats->count(), 'recordsFiltered' => $stats->count(), 'data' => $stats];
    }

    public function datadump(Request $request) {
        $stats = collect();
        $wk = $request->has('week_selection') ? $request->get('week_selection') : false;
        $cases = \App\SSECase::weekly($wk)->get();
        switch (Auth::user()->roles) {
            case 'MANAGER':
            case 'SOM':
                break;
            case 'SUPERVISOR':
                break;
            default:
                break;
        }
    }

    public function usersettings(Request $request) {
        $settings = Auth::user()->settings->where('type', $request->get('type'));
        if ($settings->count() <= 0) {
            $_data = [
                'uid' => Auth::user()->uid,
                'type' => $request->get('type'),
                'entries' => json_encode($request->get('entries'))
            ];
            return \App\Settings::create($_data);
        } else {
            if (json_encode($request->get('entries')) != nullValue())
                $settings->first()->entries = json_encode($request->get('entries'));
            else
                $settings->first()->entries = "[]";
            return $settings->first()->save() ? 1 : 0;
        }
    }

    public function show_profile_image($uid) {
        $emp = \App\Employee::findOrFail($uid);
        $response = \Response::make($emp->image, 200);
        $response->header('Content-Type', 'image/jpeg');
        return $response;
    }
    
    public function showSignature($uid) {
        $emp = \App\Employee::findOrFail($uid);
        $response = \Response::make($emp->signature, 200);
        $response->header('Content-Type', 'image/png');
        return $response;
    }

    public function impersonate($uid) {
        $user = \App\Employee::where('username', $uid)->first();
        Auth::login($user);
        return redirect('/');
    }

    public function assignrole($msg = false) {
        $data['msg'] = $msg == 'updated' ? 'success' : '';
        $data['agents'] = \App\Employee::where('active', '1')->where('roles', '!=', 'L2')->orderBy('lname', 'asc')->get();
        $data['page_title'] = 'External Roles';
        $data['name'] = 'Assign External Roles';
        $data['page_desc'] = 'Allows Members of Special Task Team to assign roles to employees.';
        
        return view('tools.assignrole', $data);
    }

    public function updaterole(Request $request) {
        if ($request->input('submit'))
            $details = array(
                'uid' => $request->get('uid'),
                'role' => $request->get('role'),
                'added_by' => Auth::user()->uid,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            );
        DB::table('external_roles')->insert($details);
        return redirect('roles/updated');
    }

}
