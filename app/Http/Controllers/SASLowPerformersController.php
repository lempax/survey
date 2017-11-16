<?php

namespace App\Http\Controllers;

use App\SASLowPerformersCases;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use Auth;
use Session;
use App\Employee as Employee;

class SASLowPerformersController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        if (Auth::check()) {
            $_team = Auth::user()->teams();
            if ($_team->count() == 1 && $_team->first()->departmentid = 21395000) {
                $this->teams = \App\Department::where('name', 'like', 'U%')->get();
            } else {
                $this->teams = Auth::user()->teams();
                $this->exemptions = Auth::user()->settings()->type('filtered_list')->first() ? json_decode(Auth::user()->settings()->type('filtered_list')->first()->entries) : [];
            }
        }
    }

    public function newcase() {

        $breakdown = [
            'name' => 'Cases Processed',
            'headers' => ['ID', 'Date Created', 'Team Name', 'Agent Name', 'Total Calls of the Week'],
            'headerStyle' => ['', '', '', '', ''],
            'data' => []
        ];
           
        $sas = new SASLowPerformersCases();
       
        $data['rows'] = $sas->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'SAS Low Performers';
        $data['page_desc'] = 'Displays all cases Zero SAS cases.';
        $data['perfurl'] = 'sas';
        $data['form_title'] = "Your cases for " . date("F j, Y");
        return view('saslowperformers.SASLowPerformersViewReport', $data);
    }

    public function storecase(Request $request) {
        $this->validate($request, [
                'team_name' => 'required',
                'agent_name' => 'required',
                'total_calls' => 'required|integer',
                'reasons' => 'required',
                'sup_actionplan' => 'required'
        ]);
         
        $insertData = array(
            'team_name' => $request->get('team_name'),
            'agent_name' => $request->get('agent_name'),
            'total_calls' => $request->get('total_calls'),
            'reasons' => $request->get('reasons'),
            'sup_actionplan' => $request->get('sup_actionplan'),
        );
        
        $data['team_name'] = $request->get('team_name');
        $data['agent_name'] = Employee::where('uid', $request->get('agent_name'))->first();
        $data['total_calls'] = $request->get('total_calls');
        $data['reasons'] = $request->get('reasons');
        $data['sup_actionplan'] = $request->get('sup_actionplan');
                
        $user = Auth::user();
        Mail::send('saslowperformers.SASLowPerformersSendMail', $data, function ($message) use ($user) {
          $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
          $message->to($user->superior->email, $user->superior->name)->subject('1&1 SAS Low Performers Tool');
          $message->cc($user->email, $user->name);
          $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
        });
        SASLowPerformersCases::create($insertData);     
        Session::flash('flash_message', 'Case successfully added!');
        return redirect('sas/newcase');
    }

    public function editcase($id, Request $request){
        
        $breakdown = [
            'name' => 'Cases Processed',
            'headers' => ['ID', 'Date Created', 'Team Name', 'Agent Name', 'Total Calls of the Week'],
            'headerStyle' => ['', '', '', '', ''],
            'data' => []
        ];
           
        $sas = new SASLowPerformersCases();
        
        $data['data1'] = $sas->where('id', $id)->first();
        $data['rows'] = $sas->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'SAS Low Performers';
        $data['page_desc'] = 'Displays all cases Zero SAS cases.';
        $data['perfurl'] = 'sas';
        $data['form_title'] = "Your cases for " . date("F j, Y");
        return view('saslowperformers.SASLowPerformersEditcase', $data);
        
    }
    public function sort(){
        $breakdown = [
            'name' => 'Cases Processed',
            'headers' => ['ID', 'Date Created', 'Team Name', 'Agent Name', 'Total Calls of the Week'],
            'headerStyle' => ['', '', '', '', ''],
            'data' => []
        ];
           
        $sas = new SASLowPerformersCases();
        
        if(isset($_POST['all'])){
            $data['rows'] = $sas->get();
        }
        if(isset($_POST['today'])){
            $today = date("Y-m-d");
            $data['rows'] = $sas->where('created_at', 'LIKE', "$today%")->get();
        }
        if(isset($_POST['monthly'])){
           $month = date("Y-m");
           $data['rows'] = $sas->where('created_at', 'LIKE', "$month%")->get();
        }
        if(isset($_POST['weekly'])){
           $today = date("Y-m-d");
           $week = date('W', strtotime($today));
           $data['rows'] = $sas->where('week', 'LIKE', "$week")->get();
        }
        
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'SAS Low Performers';
        $data['perfurl'] = 'sas';
        return view('saslowperformers.SASLowPerformersViewReport', $data);
    }
}