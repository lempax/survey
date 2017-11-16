<?php

namespace App\Http\Controllers;

use App\SLPendingConcerns;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use Auth;
use Session;
use App\Employee as Employee;

class SLPendingConcernsController extends Controller {

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
            'name' => '1&1 2nd Level Pending Concerns',
            'headers' => ['Employee Name', 'Subject', 'Date', 'Status'],
            'headerStyle' => ['','', '', ''],
            'data' => []
        ];
           
        $slpc = new SLPendingConcerns();
       
        $data['rows'] = $slpc->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = '1&1 2nd Level Pending Concerns';
        $data['page_desc'] = 'Displays all tickets created for each department.';
        $data['perfurl'] = 'slpc';
        $data['form_title'] = "[Date: " . date("F j, Y"). "]";
        return view('slpendingconcerns.SLPendingConcernsView', $data);
    }

    public function store(Request $request) {
        $this->validate($request, [
                'emp_name' => 'required',
                'subject' => 'required',
                'status' => 'required',
                'concern' => 'required'
        ]);
        
        $insertData = array(
            'emp_name' => $request->get('emp_name'),
            'subject' => $request->get('subject'),
            'status' => $request->get('status'),
            'concern' => $request->get('concern'),
        );
        
        SLPendingConcerns::create($insertData);
        $data['emp_name'] = Employee::where('uid', $request->get('emp_name'))->first();
        $data['subject'] = $request->get('subject');
        $data['status'] = $request->get('status');
        $data['concern'] = $request->get('concern');
        
       
        $user = Auth::user();
        Mail::send('slpendingconcerns.SLPendingConcernsSendMail', $data, function ($message) use ($user) {
           $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
           $message->to($user->superior->email, $user->superior->name)->subject('1&1 2nd Level Pending Concerns');
           $message->cc($user->email, $user->name);
           $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
        });

        Session::flash('flash_message', 'Case successfully added!');
        return redirect('slpc/newcase');
    }
    public function edit($id, Request $request){
        
        $breakdown = [
            'name' => '1&1 2nd Level Pending Concerns',
            'headers' => ['Employee Name', 'Subject', 'Date', 'Status'],
            'headerStyle' => ['','', '', ''],
            'data' => []
        ];
           
        $slpc = new SLPendingConcerns();
        
        $data['data1'] = $slpc->where('id', $id)->first();
        $data['rows'] = $slpc->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = '1&1 2nd Level Pending Concerns';
        $data['page_desc'] = 'Displays all tickets created for each department.';
        $data['perfurl'] = 'slpc';
        $data['form_title'] = "Your cases for " . date("F j, Y");
        return view('slpendingconcerns.SLPendingConcernsEdit', $data);
        
    }
    
    public function sort(){
        $breakdown = [
            'name' => '1&1 2nd Level Pending Concerns',
            'headers' => ['Employee Name', 'Subject', 'Date', 'Status'],
            'headerStyle' => ['','', '', ''],
            'data' => []
        ];
           
        $slpc = new SLPendingConcerns();
        
        if(isset($_POST['all'])){
            $data['rows'] = $slpc->get();
        }
        if(isset($_POST['today'])){
            $today = date("Y-m-d");
            $data['rows'] = $slpc->where('created_at', 'LIKE', "$today%")->get();
        }
        if(isset($_POST['monthly'])){
           $month = date("Y-m");
           $data['rows'] = $slpc->where('created_at', 'LIKE', "$month%")->get();
        }
        if(isset($_POST['weekly'])){
           $today = date("Y-m-d");
           $week = date('W', strtotime($today));
           $data['rows'] = $slpc->where('week', 'LIKE', "$week")->get();
        }
        
        $data['breakdown'] = $breakdown;
        $data['page_title'] = '1&1 2nd Level Pending Concerns';
        $data['perfurl'] = 'slpc';
        return view('slpendingconcerns.SLPendingConcernsView', $data);
    }
}                                                                                                       