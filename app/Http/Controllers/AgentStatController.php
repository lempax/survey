<?php

namespace App\Http\Controllers;

use Auth;
use Excel;
use App\AgentStackrank;
use App\AgentCQN;
use App\AgentProd;
use App\AgentSas;
use App\AgentReleasedRate;
use App\AgentAht;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class AgentStatController extends Controller {

    private $teams;
    private $exemptions;

    public function __construct() {
        $this->middleware('auth');
        if (Auth::check()) {
            $_team = Auth::user()->teams();
            if ($_team->count() == 1 && $_team->first()->departmentid = 21395000)
                $this->teams = \App\Department::where('name', 'like', 'U%')->get();
            else
                switch (Auth::user()->departmentid) {
                    case 21395000:
                        $this->teams = \App\Department::where('name', 'like', '%UK Web Hosting %')->get();
                        break;
                    case 21437605:
                        $this->teams = \App\Department::where('name', 'like', '%US Web Hosting %')->get();
                        break;
                    default:
                        $this->teams = Auth::user()->teams();
                        break;
                }

            $this->exemptions = Auth::user()->settings()->type('filtered_list')->first() ?
                    json_decode(Auth::user()->settings()->type('filtered_list')->first()->entries) : [];
        }
    }

    public function Upload() {
        $data['page_title'] = 'Agent Statistics';
        $data['page_desc'] = 'Allow managers, supervisors to upload csv or excel files.';
        $data['perfurl'] = 'agentstat/upload';
        return view('agent_stat.upload', $data);
    }

    public function importStackRank(Request $request) {
        if (Input::hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
                        
                    })->get();
            if (!empty($data) && $data->count()) {
                foreach ($data as $key => $value) {
                    $insert[] = [
                        'rid' => time(),
                        'agent' => $value->agent,
                        'team' => $value->team,
                        'jan_cr' => $value->jan_cr,
                        'jan_feed' => $value->jan_feed,
                        'feb_cr' => $value->feb_cr,
                        'feb_feed' => $value->feb_feed,
                        'mar_cr' => $value->mar_cr,
                        'mar_feed' => $value->mar_feed,
                        'april_cr' => $value->april_cr,
                        'april_feed' => $value->april_feed,
                        'may_cr' => $value->may_cr,
                        'may_feed' => $value->may_feed,
                        'june_cr' => $value->june_cr,
                        'june_feed' => $value->june_feed,
                        'july_cr' => $value->july_cr,
                        'july_feed' => $value->july_feed,
                        'aug_cr' => $value->aug_cr,
                        'aug_feed' => $value->aug_feed,
                        'sept_cr' => $value->sept_cr,
                        'sept_feed' => $value->sept_feed,
                        'oct_cr' => $value->oct_cr,
                        'oct_feed' => $value->oct_feed,
                        'nov_cr' => $value->nov_cr,
                        'nov_feed' => $value->nov_feed,
                        'dec_cr' => $value->dec_cr,
                        'dec_feed' => $value->dec_feed,
                        'ave_cr' => $value->ave_cr,
                        'rank_cr' => $value->rank_cr,
                        'jan_q' => $value->jan_q,
                        'feb_q' => $value->feb_q,
                        'mar_q' => $value->mar_q,
                        'april_q' => $value->april_q,
                        'may_q' => $value->may_q,
                        'june_q' => $value->june_q,
                        'july_q' => $value->july_q,
                        'aug_q' => $value->aug_q,
                        'sept_q' => $value->sept_q,
                        'oct_q' => $value->oct_q,
                        'nov_q' => $value->nov_q,
                        'dec_q' => $value->dec_q,
                        'ave_q' => $value->ave_q,
                        'rank_q' => $value->rank_q,
                        'jan_nps' => $value->jan_nps,
                        'feb_nps' => $value->feb_nps,
                        'mar_nps' => $value->mar_nps,
                        'april_nps' => $value->april_nps,
                        'may_nps' => $value->may_nps,
                        'june_nps' => $value->june_nps,
                        'july_nps' => $value->july_nps,
                        'aug_nps' => $value->aug_nps,
                        'sept_nps' => $value->sept_nps,
                        'oct_nps' => $value->oct_nps,
                        'nov_nps' => $value->nov_nps,
                        'dec_nps' => $value->dec_nps,
                        'ave_nps' => $value->ave_nps,
                        'rank_nps' => $value->rank_nps,
                        'jan_prod' => $value->jan_prod,
                        'feb_prod' => $value->feb_prod,
                        'mar_prod' => $value->mar_prod,
                        'april_prod' => $value->april_prod,
                        'may_prod' => $value->may_prod,
                        'june_prod' => $value->june_prod,
                        'july_prod' => $value->july_prod,
                        'aug_prod' => $value->aug_prod,
                        'sept_prod' => $value->sept_prod,
                        'oct_prod' => $value->oct_prod,
                        'nov_prod' => $value->nov_prod,
                        'dec_prod' => $value->dec_prod,
                        'ave_prod' => $value->ave_prod,
                        'rank_prod' => $value->rank_prod,
                        'jan_sas' => $value->jan_sas,
                        'feb_sas' => $value->feb_sas,
                        'mar_sas' => $value->mar_sas,
                        'april_sas' => $value->april_sas,
                        'may_sas' => $value->may_sas,
                        'june_sas' => $value->june_sas,
                        'july_sas' => $value->july_sas,
                        'aug_sas' => $value->aug_sas,
                        'sept_sas' => $value->sept_sas,
                        'oct_sas' => $value->oct_sas,
                        'nov_sas' => $value->nov_sas,
                        'dec_sas' => $value->dec_sas,
                        'ave_sas' => $value->ave_sas,
                        'rank_sas' => $value->rank_sas,
                        'jan_rel' => $value->jan_rel,
                        'feb_rel' => $value->feb_rel,
                        'mar_rel' => $value->mar_rel,
                        'april_rel' => $value->april_rel,
                        'may_rel' => $value->may_rel,
                        'june_rel' => $value->june_rel,
                        'july_rel' => $value->july_rel,
                        'aug_rel' => $value->aug_rel,
                        'sept_rel' => $value->sept_rel,
                        'oct_rel' => $value->oct_rel,
                        'nov_rel' => $value->nov_rel,
                        'dec_rel' => $value->dec_rel,
                        'ave_rel' => $value->ave_rel,
                        'rank_rel' => $value->rank_rel,
                        'jan_aht' => $value->jan_aht,
                        'feb_aht' => $value->feb_aht,
                        'mar_aht' => $value->mar_aht,
                        'april_aht' => $value->april_aht,
                        'may_aht' => $value->may_aht,
                        'june_aht' => $value->june_aht,
                        'july_aht' => $value->july_aht,
                        'aug_aht' => $value->aug_aht,
                        'sept_aht' => $value->sept_aht,
                        'oct_aht' => $value->oct_aht,
                        'nov_aht' => $value->nov_aht,
                        'dec_aht' => $value->dec_aht,
                        'ave_aht' => $value->ave_aht,
                        'rank_aht' => $value->rank_aht,
                        'total' => $value->total,
                        'overall' => $value->overall,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")];
                }
                if (!empty($insert)) {
                    $report = array(
                        'sid' => time(),
                        'type' => 'sr',
                        'desc' => 'Agent Stack Rank',
                        'uid' => Auth::user()->uid,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    );
                    
                    DB::table('agent_stats')->insert($report);
                    DB::table('agent_stack_rank')->insert($insert);
                    
                    dd('Insert Record Successfully');
                }
            }
        }
        return back();
    }

    public function importCQN(Request $request) {
        if (Input::hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
                        
                    })->get();
            if (!empty($data) && $data->count()) {
                foreach ($data as $key => $value) {
                    $insert[] = [
                        'rid' => time(),
                        'team' => $value->team,
                        'jan_feed' => $value->jan_feed,
                        'jan_q' => $value->jan_q,
                        'jan_fcr' => $value->jan_fcr,
                        'jan_crr' => $value->jan_crr,
                        'jan_nps' => $value->jan_nps,
                        'feb_feed' => $value->feb_feed,
                        'feb_q' => $value->feb_q,
                        'feb_fcr' => $value->feb_fcr,
                        'feb_crr' => $value->feb_crr,
                        'feb_nps' => $value->feb_nps,
                        'mar_feed' => $value->mar_feed,
                        'mar_q' => $value->mar_q,
                        'mar_fcr' => $value->mar_fcr,
                        'mar_crr' => $value->mar_crr,
                        'mar_nps' => $value->mar_nps,
                        'april_feed' => $value->april_feed,
                        'april_q' => $value->april_q,
                        'april_fcr' => $value->april_fcr,
                        'april_crr' => $value->april_crr,
                        'april_nps' => $value->april_nps,
                        'may_feed' => $value->may_feed,
                        'may_q' => $value->may_q,
                        'may_fcr' => $value->may_fcr,
                        'may_crr' => $value->may_crr,
                        'may_nps' => $value->may_nps,
                        'june_feed' => $value->june_feed,
                        'june_q' => $value->june_q,
                        'june_fcr' => $value->june_fcr,
                        'june_crr' => $value->june_crr,
                        'june_nps' => $value->june_nps,
                        'july_feed' => $value->july_feed,
                        'july_q' => $value->july_q,
                        'july_fcr' => $value->july_fcr,
                        'july_crr' => $value->july_crr,
                        'july_nps' => $value->july_nps,
                        'aug_feed' => $value->aug_feed,
                        'aug_q' => $value->aug_q,
                        'aug_fcr' => $value->aug_fcr,
                        'aug_crr' => $value->aug_crr,
                        'aug_nps' => $value->aug_nps,
                        'sept_feed' => $value->sept_feed,
                        'sept_q' => $value->sept_q,
                        'sept_fcr' => $value->sept_fcr,
                        'sept_crr' => $value->sept_crr,
                        'sept_nps' => $value->sept_nps,
                        'oct_feed' => $value->oct_feed,
                        'oct_q' => $value->oct_q,
                        'oct_fcr' => $value->oct_fcr,
                        'oct_crr' => $value->oct_crr,
                        'oct_nps' => $value->oct_nps,
                        'nov_feed' => $value->nov_feed,
                        'nov_q' => $value->nov_q,
                        'nov_fcr' => $value->nov_fcr,
                        'nov_crr' => $value->nov_crr,
                        'nov_nps' => $value->nov_nps,
                        'dec_feed' => $value->dec_feed,
                        'dec_q' => $value->dec_q,
                        'dec_fcr' => $value->dec_fcr,
                        'dec_crr' => $value->dec_crr,
                        'dec_nps' => $value->dec_nps,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")];
                }
                if (!empty($insert)) 
                {
                    $report = array(
                        'sid' => time(),
                        'type' => 'cqn',
                        'desc' => 'CRR, Quality, NPS',
                        'uid' => Auth::user()->uid,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    );
                    
                    DB::table('agent_stats')->insert($report);
                    
                    DB::table('agent_cqn')->insert($insert);
                    dd('Insert Record Successfully');
                }
            }
        }
        return back();
    }

    public function importProd(Request $request) {
        if (Input::hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
                        
                    })->get();
            if (!empty($data) && $data->count()) {
                foreach ($data as $key => $value) {
                    $insert[] = [
                        'rid' => time(),
                        'team' => $value->team,
                        'teamname' => $value->teamname,
                        'jan_diff' => $value->jan_diff,
                        'jan_email' => $value->jan_email,
                        'jan_sse' => $value->jan_sse,
                        'jan_calls' => $value->jan_calls,
                        'jan_prod' => $value->jan_prod,
                        'feb_diff' => $value->feb_diff,
                        'feb_email' => $value->feb_email,
                        'feb_sse' => $value->feb_sse,
                        'feb_calls' => $value->feb_calls,
                        'feb_prod' => $value->feb_prod,
                        'mar_diff' => $value->mar_diff,
                        'mar_email' => $value->mar_email,
                        'mar_sse' => $value->mar_sse,
                        'mar_calls' => $value->mar_calls,
                        'mar_prod' => $value->mar_prod,
                        'april_diff' => $value->april_diff,
                        'april_email' => $value->april_email,
                        'april_sse' => $value->april_sse,
                        'april_calls' => $value->april_calls,
                        'april_prod' => $value->april_prod,
                        'may_diff' => $value->may_diff,
                        'may_email' => $value->may_email,
                        'may_sse' => $value->may_sse,
                        'may_calls' => $value->may_calls,
                        'may_prod' => $value->may_prod,
                        'june_diff' => $value->june_diff,
                        'june_email' => $value->june_email,
                        'june_sse' => $value->june_sse,
                        'june_calls' => $value->june_calls,
                        'june_prod' => $value->june_prod,
                        'july_diff' => $value->july_diff,
                        'july_email' => $value->july_email,
                        'july_sse' => $value->july_sse,
                        'july_calls' => $value->july_calls,
                        'july_prod' => $value->july_prod,
                        'aug_diff' => $value->aug_diff,
                        'aug_email' => $value->aug_email,
                        'aug_sse' => $value->aug_sse,
                        'aug_calls' => $value->aug_calls,
                        'aug_prod' => $value->aug_prod,
                        'sept_diff' => $value->sept_diff,
                        'sept_email' => $value->sept_email,
                        'sept_sse' => $value->sept_sse,
                        'sept_calls' => $value->sept_calls,
                        'sept_prod' => $value->sept_prod,
                        'oct_diff' => $value->oct_diff,
                        'oct_email' => $value->oct_email,
                        'oct_sse' => $value->oct_sse,
                        'oct_calls' => $value->oct_calls,
                        'oct_prod' => $value->oct_prod,
                        'nov_diff' => $value->nov_diff,
                        'nov_email' => $value->nov_email,
                        'nov_sse' => $value->nov_sse,
                        'nov_calls' => $value->nov_calls,
                        'nov_prod' => $value->nov_prod,
                        'dec_diff' => $value->dec_diff,
                        'dec_email' => $value->dec_email,
                        'dec_sse' => $value->dec_sse,
                        'dec_calls' => $value->dec_calls,
                        'dec_prod' => $value->dec_prod,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")];
                }
                if (!empty($insert)) {
                    
                    $report = array(
                        'sid' => time(),
                        'type' => 'pr',
                        'desc' => 'Agent Productivity',
                        'uid' => Auth::user()->uid,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    );
                    
                    DB::table('agent_stats')->insert($report);
                    DB::table('agent_prod')->insert($insert);
                    dd('Insert Record Successfully');
                }
            }
        }
        return back();
    }

    public function importSas(Request $request) {
        if (Input::hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
                        
                    })->get();
            if (!empty($data) && $data->count()) {
                foreach ($data as $key => $value) {
                    $insert[] = [
                        'rid' => time(),
                        'team' => $value->team,
                        'jan_sas' => $value->jan_sas,
                        'jan_calls' => $value->jan_calls,
                        'jan_cr' => $value->jan_cr,
                        'feb_sas' => $value->feb_sas,
                        'feb_calls' => $value->feb_calls,
                        'feb_cr' => $value->feb_cr,
                        'mar_sas' => $value->mar_sas,
                        'mar_calls' => $value->mar_calls,
                        'mar_cr' => $value->mar_cr,
                        'april_sas' => $value->april_sas,
                        'april_calls' => $value->april_calls,
                        'april_cr' => $value->april_cr,
                        'may_sas' => $value->may_sas,
                        'may_calls' => $value->may_calls,
                        'may_cr' => $value->may_cr,
                        'june_sas' => $value->june_sas,
                        'june_calls' => $value->june_calls,
                        'june_cr' => $value->june_cr,
                        'july_sas' => $value->july_sas,
                        'july_calls' => $value->july_calls,
                        'july_cr' => $value->july_cr,
                        'aug_sas' => $value->aug_sas,
                        'aug_calls' => $value->aug_calls,
                        'aug_cr' => $value->aug_cr,
                        'sept_sas' => $value->sept_sas,
                        'sept_calls' => $value->sept_calls,
                        'sept_cr' => $value->sept_cr,
                        'oct_sas' => $value->oct_sas,
                        'oct_calls' => $value->oct_calls,
                        'oct_cr' => $value->oct_cr,
                        'nov_sas' => $value->nov_sas,
                        'nov_calls' => $value->nov_calls,
                        'nov_cr' => $value->nov_cr,
                        'dec_sas' => $value->dec_sas,
                        'dec_calls' => $value->dec_calls,
                        'dec_cr' => $value->dec_cr,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")];
                }
                if (!empty($insert)) {
                    
                    $report = array(
                        'sid' => time(),
                        'type' => 'sas',
                        'desc' => 'Agent SAS',
                        'uid' => Auth::user()->uid,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    );
                    
                    DB::table('agent_stats')->insert($report);
                    DB::table('agent_sas')->insert($insert);
                    dd('Insert Record Successfully');
                }
            }
        }
        return back();
    }

    public function importReleased(Request $request) {
        if (Input::hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
                        
                    })->get();
            if (!empty($data) && $data->count()) {
                foreach ($data as $key => $value) {
                    $insert[] = [
                        'rid' => time(),
                        'team' => $value->team,
                        'jan_total' => $value->jan_total,
                        'jan_calls' => $value->jan_calls,
                        'jan_ave' => $value->jan_ave,
                        'feb_total' => $value->feb_total,
                        'feb_calls' => $value->feb_calls,
                        'feb_ave' => $value->feb_ave,
                        'mar_total' => $value->mar_total,
                        'mar_calls' => $value->mar_calls,
                        'mar_ave' => $value->mar_ave,
                        'april_total' => $value->april_total,
                        'april_calls' => $value->april_calls,
                        'april_ave' => $value->april_ave,
                        'may_total' => $value->may_total,
                        'may_calls' => $value->may_calls,
                        'may_ave' => $value->may_ave,
                        'june_total' => $value->june_total,
                        'june_calls' => $value->june_calls,
                        'june_ave' => $value->june_ave,
                        'july_total' => $value->july_total,
                        'july_calls' => $value->july_calls,
                        'july_ave' => $value->july_ave,
                        'aug_total' => $value->aug_total,
                        'aug_calls' => $value->aug_calls,
                        'aug_ave' => $value->aug_ave,
                        'sept_total' => $value->sept_total,
                        'sept_calls' => $value->sept_calls,
                        'sept_ave' => $value->sept_ave,
                        'oct_total' => $value->oct_total,
                        'oct_calls' => $value->oct_calls,
                        'oct_ave' => $value->oct_ave,
                        'nov_total' => $value->nov_total,
                        'nov_calls' => $value->nov_calls,
                        'nov_ave' => $value->nov_ave,
                        'dec_total' => $value->dec_total,
                        'dec_calls' => $value->dec_calls,
                        'dec_ave' => $value->dec_ave,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")];
                }
                if (!empty($insert)) {
                    $report = array(
                        'sid' => time(),
                        'type' => 'rr',
                        'desc' => 'Agent Released Rate',
                        'uid' => Auth::user()->uid,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    );
                    
                    DB::table('agent_stats')->insert($report);
                    DB::table('agent_released')->insert($insert);
                    dd('Insert Record Successfully');
                }
            }
        }
        return back();
    }

    public function importAHT(Request $request) {
        if (Input::hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
                        
                    })->get();
            if (!empty($data) && $data->count()) {
                foreach ($data as $key => $value) {
                    $insert[] = [
                        'rid' => time(),
                        'team' => $value->team,
                        'jan_login' => $value->jan_login,
                        'jan_aht_out' => $value->jan_aht_out,
                        'jan_in_out' => $value->jan_in_out,
                        'jan_aht_in' => $value->jan_aht_in,
                        'feb_login' => $value->feb_login,
                        'feb_aht_out' => $value->feb_aht_out,
                        'feb_in_out' => $value->feb_in_out,
                        'feb_aht_in' => $value->feb_aht_in,
                        'mar_login' => $value->mar_login,
                        'mar_aht_out' => $value->mar_aht_out,
                        'mar_in_out' => $value->mar_in_out,
                        'mar_aht_in' => $value->mar_aht_in,
                        'april_login' => $value->april_login,
                        'april_aht_out' => $value->april_aht_out,
                        'april_in_out' => $value->april_in_out,
                        'april_aht_in' => $value->april_aht_in,
                        'may_login' => $value->may_login,
                        'may_aht_out' => $value->may_aht_out,
                        'may_in_out' => $value->may_in_out,
                        'may_aht_in' => $value->may_aht_in,
                        'june_login' => $value->june_login,
                        'june_aht_out' => $value->june_aht_out,
                        'june_in_out' => $value->june_in_out,
                        'june_aht_in' => $value->june_aht_in,
                        'july_login' => $value->july_login,
                        'july_aht_out' => $value->july_aht_out,
                        'july_in_out' => $value->july_in_out,
                        'july_aht_in' => $value->july_aht_in,
                        'aug_login' => $value->aug_login,
                        'aug_aht_out' => $value->aug_aht_out,
                        'aug_in_out' => $value->aug_in_out,
                        'aug_aht_in' => $value->aug_aht_in,
                        'sept_login' => $value->sept_login,
                        'sept_aht_out' => $value->sept_aht_out,
                        'sept_in_out' => $value->sept_in_out,
                        'sept_aht_in' => $value->sept_aht_in,
                        'oct_login' => $value->oct_login,
                        'oct_aht_out' => $value->oct_aht_out,
                        'oct_in_out' => $value->oct_in_out,
                        'oct_aht_in' => $value->oct_aht_in,
                        'nov_login' => $value->nov_login,
                        'nov_aht_out' => $value->nov_aht_out,
                        'nov_in_out' => $value->nov_in_out,
                        'nov_aht_in' => $value->nov_aht_in,
                        'dec_login' => $value->dec_login,
                        'dec_aht_out' => $value->dec_aht_out,
                        'dec_in_out' => $value->dec_in_out,
                        'dec_aht_in' => $value->dec_aht_in,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")];
                }
                if (!empty($insert)) {
                    $report = array(
                        'sid' => time(),
                        'type' => 'aht',
                        'desc' => 'Agent AHT',
                        'uid' => Auth::user()->uid,
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")
                    );
                    
                    DB::table('agent_stats')->insert($report);
                    DB::table('agent_aht')->insert($insert);
                    dd('Insert Record Successfully');
                }
            }
        }
        return back();
    }
    
    public function stat_reports(){
        $data['summary'] = DB::table('agent_stack_rank')
                    ->select(DB::raw('team, FORMAT(AVG(ave_cr), 2) AS cr, FORMAT(AVG(ave_q), 2) AS q, FORMAT(AVG(ave_nps), 2) AS nps, FORMAT(AVG(ave_prod), 2) AS prod, FORMAT(AVG(ave_sas), 2) AS sas'))
                    ->groupBy('team')
                    ->get();
        
        $sr = [
            'name' => '',
            'headers' => ['Report ID', 'Description', 'Uploaded By', 'Created At', 'Updated At'],
            'headerStyle' => ['', '', '', '', ''],
            'data' => []
        ];
        
        $cqn= [];
        $pr = [];
        $sas = [];
        $rr = [];
        $aht = [];

        foreach (Auth::user()->stat_reports()->stackrank()->get() AS $case) {
            $sr['data'][] = [
               '<a href="agentstat/open_sr/'.$case->sid.'" class="label bg-olive" style="font-size: 13px;">'.$case->sid.'</a>', $case->desc.' Report', $case->user->name, date("F j, Y", strtotime($case->created_at)), date("F j, Y", strtotime($case->updated_at)) 
            ];
        }


        foreach (Auth::user()->stat_reports()->cqn()->get() AS $case) {
            $cqn['data'][] = [
               '<a href="agentstat/open_cqn/'.$case->sid.'" class="label bg-primary" style="font-size: 13px;">'.$case->sid.'</a>', $case->desc.' Report', $case->user->name, date("F j, Y", strtotime($case->created_at)), date("F j, Y", strtotime($case->updated_at)) 
            ];
        }

        foreach (Auth::user()->stat_reports()->prod()->get() AS $case) {
            $pr['data'][] = [
               '<a href="agentstat/open_prod/'.$case->sid.'" class="label bg-maroon" style="font-size: 13px;">'.$case->sid.'</a>', $case->desc.' Report', $case->user->name, date("F j, Y", strtotime($case->created_at)), date("F j, Y", strtotime($case->updated_at)) 
            ];
        }

        foreach (Auth::user()->stat_reports()->sas()->get() AS $case) {
            $sas['data'][] = [
               '<a href="agentstat/open_sas/'.$case->sid.'" class="label bg-red" style="font-size: 13px;">'.$case->sid.'</a>', $case->desc.' Report', $case->user->name, date("F j, Y", strtotime($case->created_at)), date("F j, Y", strtotime($case->updated_at)) 
            ];
        }

        foreach (Auth::user()->stat_reports()->released()->get() AS $case) {
            $rr['data'][] = [
               '<a href="agentstat/open_rr/'.$case->sid.'" class="label bg-orange" style="font-size: 13px;">'.$case->sid.'</a>', $case->desc.' Report', $case->user->name, date("F j, Y", strtotime($case->created_at)), date("F j, Y", strtotime($case->updated_at)) 
            ];
        }

        foreach (Auth::user()->stat_reports()->aht()->get() AS $case) {
            $aht['data'][] = [
               '<a href="agentstat/open_aht/'.$case->sid.'" class="label bg-navy" style="font-size: 13px;">'.$case->sid.'</a>', $case->desc.' Report', $case->user->name, date("F j, Y", strtotime($case->created_at)), date("F j, Y", strtotime($case->updated_at)) 
            ];
        }
        
        $data['sr'] = $sr;
        $data['cqn'] = $cqn;
        $data['pr'] = $pr;
        $data['sas'] = $sas;
        $data['rr'] = $rr;
        $data['aht'] = $aht;
        
        $data['page_title'] = 'Agent Statistics Reports';
        $data['page_desc'] = 'Displays all uploaded reports such as crr, quality, nps, released, stack rank.';
        $data['perfurl'] = 'agentstat';
        return view('agent_stat.stats', $data);
    }
    
    public function open_stackrank($id){
        $sr_data = new AgentStackrank();
        $detail = $sr_data->where('rid', $id)->get();
        $sr = [
            'name' => '',
            'headers' => ['Employee', 'Team', 'Ave', 'Rank', 'Ave', 'Rank', 'Ave', 'Rank', 'Ave', 'Rank', 'Ave', 'Rank', 'Ave', 'Rank', 'Ave', 'Rank', 'Overall'],
            'headerStyle' => ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''],
            'data' => []
        ];
        
        $q = [
            'name' => '',
            'headers' => ['Agent', 'Team', 'JAN', 'FEB', 'MAR', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUG', 'SEPT', 'OCT', 'NOV', 'DEC', 'Ave', 'Rank'],
            'headerStyle' => ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        foreach ($detail AS $case) {
            $sr['data'][] = [
                $case->agent, $case->team, $case->ave_cr, $case->rank_cr,
                $case->ave_q, $case->rank_q, $case->ave_nps, $case->rank_nps,
                $case->ave_prod, $case->rank_prod, $case->ave_sas, $case->rank_sas, 
                $case->ave_rel, $case->rank_rel, $case->ave_aht, $case->rank_aht, 
                $case->overall
            ];
            
            $q['data'][] = [
                $case->agent, $case->team, $case->jan_q,
                $case->feb_q,
                $case->mar_q,
                $case->april_q,
                $case->may_q,
                $case->june_q,
                $case->july_q,
                $case->aug_q,
                $case->sept_q,
                $case->oct_q,
                $case->nov_q,
                $case->dec_q,
                $case->ave_q,
                $case->rank_q
            ];
            
            $nps['data'][] = [
                $case->agent, $case->team, $case->jan_nps,
                $case->feb_nps,
                $case->mar_nps,
                $case->april_nps,
                $case->may_nps,
                $case->june_nps,
                $case->july_nps,
                $case->aug_nps,
                $case->sept_nps,
                $case->oct_nps,
                $case->nov_nps,
                $case->dec_nps,
                $case->ave_nps,
                $case->rank_nps
            ];
            
            $prod['data'][] = [
                $case->agent, $case->team, 
                $case->jan_prod,
                $case->feb_prod,
                $case->mar_prod,
                $case->april_prod,
                $case->may_prod,
                $case->june_prod,
                $case->july_prod,
                $case->aug_prod,
                $case->sept_prod,
                $case->oct_prod,
                $case->nov_prod,
                $case->dec_prod,
                $case->ave_prod,
                $case->rank_prod
            ];
            
            $sas['data'][] = [
                $case->agent, $case->team, 
                $case->jan_sas,
                $case->feb_sas,
                $case->mar_sas,
                $case->april_sas,
                $case->may_sas,
                $case->june_sas,
                $case->july_sas,
                $case->aug_sas,
                $case->sept_sas,
                $case->oct_sas,
                $case->nov_sas,
                $case->dec_sas,
                $case->ave_sas,
                $case->rank_sas
            ];
            
            $rel['data'][] = [
                $case->agent, $case->team, 
                $case->jan_rel,
                $case->feb_rel,
                $case->mar_rel,
                $case->april_rel,
                $case->may_rel,
                $case->june_rel,
                $case->july_rel,
                $case->aug_rel,
                $case->sept_rel,
                $case->oct_rel,
                $case->nov_rel,
                $case->dec_rel,
                $case->ave_rel,
                $case->rank_rel
            ];
            
            $aht['data'][] = [
                $case->agent, $case->team, 
                $case->jan_aht,
                $case->feb_aht,
                $case->mar_aht,
                $case->april_aht,
                $case->may_aht,
                $case->june_aht,
                $case->july_aht,
                $case->aug_aht,
                $case->sept_aht,
                $case->oct_aht,
                $case->nov_aht,
                $case->dec_aht,
                $case->ave_aht,
                $case->rank_aht
            ];
            
            $overall['data'][] = [
                $case->overall,
                $case->agent, 
                $case->team,
            ];
        }

        $data['type'] = 'sr';
        $data['sr'] = $sr;
        $data['cr'] = $detail;
        $data['q'] = $q;
        $data['nps'] = $nps;
        $data['prod'] = $prod;
        $data['sas'] = $sas;
        $data['rel'] = $rel;
        $data['aht'] = $aht;
        $data['overall'] = $overall;
        $data['page_title'] = 'Stack Rank';
        $data['page_desc'] = 'Displays all uploaded reports for Agent Stack Rank.';
        $data['perfurl'] = 'agentstat/open_sr';
        return view('agent_stat.stackrank', $data);
    }
    
    public function open_cqn($id){
        $cqn = new AgentCQN();
        $detail = $cqn->where('rid', $id)->get();
        
        
        $_sales = [];
        
        $cqn = [
            'name' => '',
            'headers' => ['Team', 'CRR', 'NPS', 'CRR', 'NPS', 'CRR', 'NPS', 'CRR', 'NPS', 'CRR', 'NPS', 'CRR', 'NPS', 'CRR', 'NPS'],
            'headerStyle' => ['', '', '', '', '','', '','', '','', '','', '','', '','', '','', '','', '','', '','', ''],
            'data' => []
        ];
        
        $header = [
            'name' => '',
            'headers' => ['Team', 'Feedback', 'Quality', 'FCR', 'CRR', 'NPS'],
            'headerStyle' => ['', '', '', '', '', ''],
            'data' => []
        ];
        
        foreach ($detail AS $case) {
            $cqn['data'][] = [
                $case->team, 
                $case->jan_crr, $case->jan_nps,
                $case->feb_crr, $case->feb_nps,
                $case->mar_crr, $case->mar_nps,
                $case->april_crr, $case->april_nps,
                $case->may_crr, $case->may_nps,
                $case->june_crr, $case->june_nps,
                $case->july_crr, $case->july_nps,
                $case->aug_crr, $case->aug_nps,
                $case->sept_crr, $case->sept_nps,
                $case->oct_crr, $case->oct_nps,
                $case->nov_crr, $case->nov_nps,
                $case->dec_crr, $case->dec_nps
            ];
        }
        
        
        
        $data['header'] = $header;
        $data['cqn'] = $detail;
        //$data['overview'] = $sales;
        //$data['consolidated'] = $gofo;
        $data['page_title'] = 'CRR, Quality, NPS';
        $data['page_desc'] = 'Displays all uploaded reports for CRR, Quality, NPS.';
        $data['perfurl'] = 'agentstat/open_cqn';
        return view('agent_stat.cqn', $data);
    }
    
    public function open_prod($id){
        $prod = new AgentProd();
        $detail = $prod->where('rid', $id)->get();

        $header = [
            'name' => '',
            'headers' => ['Team', 'Call Diff', 'Emails', 'SSE Calls', 'Calls', 'Production'],
            'headerStyle' => ['', '', '', '', '', ''],
            'data' => []
        ];
        
        foreach ($detail AS $case) {
            $pr['data'][] = [
                $case->team, 
                $case->jan_prod,
                $case->feb_prod,
                $case->mar_prod,
                $case->april_prod,
                $case->may_prod,
                $case->june_prod,
                $case->july_prod,
                $case->aug_prod,
                $case->sept_prod,
                $case->oct_prod,
                $case->nov_prod,
                $case->dec_prod
            ];
        }

        $data['pr'] = $pr;
        $data['prods'] = $detail;
        $data['header'] = $header;
        $data['page_title'] = 'Agent Productivity';
        $data['page_desc'] = 'Displays all uploaded reports for agent productivity.';
        $data['perfurl'] = 'agentstat/open_cqn';
        return view('agent_stat.prod', $data);
    }

    public function open_sas($id){
        $sas = new AgentSas();
        $detail = $sas->where('rid', $id)->get();
        
        $header = [
            'name' => '',
            'headers' => ['Team', 'SAS', 'Calls', 'CR%'],
            'headerStyle' => ['', '', '', '', '', ''],
            'data' => []
        ];
        
        foreach ($detail AS $case) {
            $_sas['data'][] = [
                $case->team, 
                $case->jan_cr,
                $case->feb_cr,
                $case->mar_cr,
                $case->april_cr,
                $case->may_cr,
                $case->june_cr,
                $case->july_cr,
                $case->aug_cr,
                $case->sept_cr,
                $case->oct_cr,
                $case->nov_cr,
                $case->dec_cr,
            ];
        }
        
        $data['sast'] = $_sas;
        $data['sass'] = $detail;
        $data['header'] = $header;
        $data['page_title'] = 'Agent SAS';
        $data['page_desc'] = 'Displays all uploaded reports for sales after support.';
        $data['perfurl'] = 'agentstat/open_sas';
        return view('agent_stat.sas', $data);
    }
    
    public function open_released($id){
        $rel = new AgentReleasedRate();
        $detail = $rel->where('rid', $id)->get();
        
        $header = [
            'name' => '',
            'headers' => ['Team', 'Total Released', 'Calls', 'Ave. Released'],
            'headerStyle' => ['', '', '', ''],
            'data' => []
        ];

        foreach ($detail AS $case) {
            $rr_data['data'][] = [
                $case->team, 
                $case->jan_ave,
                $case->feb_ave,
                $case->mar_ave,
                $case->april_ave,
                $case->may_ave,
                $case->june_ave,
                $case->july_ave,
                $case->aug_ave,
                $case->sept_ave,
                $case->oct_ave,
                $case->nov_ave,
                $case->dec_ave 
            ];
        }

        $data['rr_sum'] = $rr_data;
        $data['rr'] = $detail;
        $data['header'] = $header;
        
        $data['header'] = $header;
        $data['page_title'] = 'Agent Released Time';
        $data['page_desc'] = 'Displays all uploaded reports for released time.';
        $data['perfurl'] = 'agentstat/open_rr';
        return view('agent_stat.released', $data);
    }
    
    public function open_aht($id){
        $aht = new AgentAht();
        $detail = $aht->where('rid', $id)->get();
        
        $header = [
            'name' => '',
            'headers' => ['Team', 'Login Time', 'AHT Out', 'AHT In + Out', 'AHT In'],
            'headerStyle' => ['', '', '', '' , ''],
            'data' => []
        ];

        foreach ($detail AS $case) {
            $aht_data['data'][] = [
                $case->team, 
                $case->jan_aht_in,
                $case->feb_aht_in,
                $case->mar_aht_in,
                $case->april_aht_in,
                $case->may_aht_in,
                $case->june_aht_in,
                $case->july_aht_in,
                $case->aug_aht_in,
                $case->sept_aht_in,
                $case->oct_aht_in,
                $case->nov_aht_in,
                $case->dec_aht_in
            ];
        }
        
        $data['aht_sum'] = $aht_data;
        $data['aht'] = $detail;
        $data['header'] = $header;
        $data['page_title'] = 'Agent AHT';
        $data['page_desc'] = 'Displays all uploaded reports for AHT.';
        $data['perfurl'] = 'agentstat/open_aht';
        return view('agent_stat.aht', $data);
    }
    
}
