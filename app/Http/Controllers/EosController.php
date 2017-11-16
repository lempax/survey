<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use App\Employee;
use App\Department;
use App\EosReports;
use Illuminate\Http\Request;
use App\Http\Controllers\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;


class EosController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $this->home();
    }

    public function home(Request $request, EosReports $eosreports) {
        $page_title = '1&1 Cebu IT EOS Tool';
        $page_desc = 'Allows authorized users to create and manage EOS tools';
        $agents = Employee::where('active', 1)->whereIn('roles', array('MANAGER', 'SUPERVISOR', 'SOM'))->get();

        foreach ($agents AS $agent) {
            if ($agent->email != '') {
                $emails[] = '"' . $agent->email . '"';
            }
        }

        $hardware = 0;
        $software = 0;
        $cosmocom = 0;
        $network = 0;
        $virus = 0;
        $ups = 0;
        $mis = 0;

        if (!empty($emails)) {
            $_emails = implode(",", $emails);
        }

        $eosreports = EosReports::get();
        $eos_week = EosReports::where(\DB::raw('YEARWEEK(created_at, 1)'), '=', \DB::raw('YEARWEEK(curdate(), 1)'))->get();

        if (!empty($eos_week)) {
            foreach ($eos_week AS $eosreport) {
                if (!empty($eosreport->tickets)) {
                    $tickets = json_decode($eosreport->tickets);
                    foreach ($tickets AS $_tickets) {
                        switch ($_tickets->category) {
                            case "hardware":
                                $hardware++;
                                break;
                            case "software":
                                $software++;
                                break;
                            case "ups":
                                $ups++;
                                break;
                            case "cosmocom":
                                $cosmocom++;
                                break;
                            case "network":
                                $network++;
                                break;
                            case "mis":
                                $mis++;
                                break;
                            case "virus":
                                $virus++;
                                break;
                        }
                    }
                }
            }
        }
        
        $session_user = Auth::id();
        $unsent = EosReports::where('logged_by', $session_user)->where('status', 'saved')->count();
        return view('eos.home', compact('page_title', 'page_desc', 'eosreports', '_emails', 'hardware', 'software', 'ups', 'cosmocom', 'network', 'mis', 'virus', 'session_user', 'unsent'));
    }

    public function save(Request $request, EosReports $eosreports) {
        $ids = explode(',', $request->get('email_cc'));
        $tickets = $request->get('ticket_desc');
        $category = $request->get('category');
        $items = [];
      	$fin_impact=$request->get('fin_impact');
        $challenges=$request->get('challenges');
        $shift_highlight=$request->get('shift_highlight');
        $shift_lowlight=$request->get('shift_lowlight');
        $tickets_in=$request->get('tickets_in');
        $tickets_out=$request->get('tickets_out');
        
        foreach ($ids AS $id) {
            $uid = \App\Employee::where('email', $id)->first();
            $uids[] = $uid->uid;
        }

        for ($i = 0; $i < count($request->get('ticket_desc')); $i++) {
            array_push($items, array('category' => $category[$i], 'ticket_desc' => $tickets[$i]));
        }

        $request->request->add([
            'fin_impact' => $fin_impact,
            'shift_higlight' => $shift_highlight,
            'shift_lowlight' => $shift_lowlight,
            'challenges' => $challenges,
            'end_no_tickets' => $tickets_out,
            'start_no_tickets' => $tickets_in,
            'status' => 'saved',
            'tickets' => json_encode($items),
            'cc' => json_encode($uids)
        ]);
        $arr = $request->all();
        $arr['logged_by'] = Auth::id();
        $arr['deptid'] = Auth::user()->departmentid;
        $surveyItem = $eosreports->create($arr);
        return Redirect::to("/eos");
    }

    public function send($id, EosReports $eosreports, Request $request) {
        $eos = EosReports::find($id);
        $data['tickets'] = json_decode($eos->tickets);
        $data['summary'] = $eos->summary;
        $data['challenges'] = $eos->challenges;
        $data['fin_impact'] = $eos->fin_impact;
        $data['shift_highlight'] = $eos->shift_highlight;
        $data['shift_lowlight'] = $eos->shift_lowlight;
        $data['start_no_tickets'] = $eos->start_no_tickets;
        $data['end_no_tickets'] = $eos->end_no_tickets;
        $data['title'] = '1&1 IT End of Shift Report';
        $data['user'] = Auth::user()->name;
        $user = Auth::user();

        EosReports::where('id', $id)->update(['status' => 'sent']);
        Mail::send('eos.email', $data, function ($message) use ($user) {
            $message->from($user->email, $user->name);
            $message->to('cebuit@1and1.com', '1&1 IT End of Shift Report')->subject('1&1 IT End of Shift Report');
        });
        return Redirect::to("/eos");
    }

    public function edit($id, EosReports $request) {
       
       $eos=  EosReports::find($id);
       return 'Page Under Constraction!!!';
    }

    public function delete() {
        
    }

    public function graphs() {
        
    }

}
