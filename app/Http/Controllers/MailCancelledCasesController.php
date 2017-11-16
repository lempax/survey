<?php

namespace App\Http\Controllers;

use App\MailCancelledCases;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use Auth;
use Session;
use App\Employee as Employee;

class MailCancelledCasesController extends Controller {

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
            'name' => '1&1 Mail.com Cancelled Cases',
            'headers' => ['Employee Name', 'Customer ID', 'Contract ID', 'Email Address', 'Case ID', 'Date Requested', 'Date Effect', 'Reason', 'Date Created'],
            'headerStyle' => ['','', '', '', '', '', '', '', ''],
            'data' => []
        ];
           
        $mcc = new MailCancelledCases();
       
        $data['rows'] = $mcc->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = '1&1 Mail.com Cancelled Cases';
        $data['page_desc'] = 'Displays all cases created by the Mail.com team.';
        $data['perfurl'] = 'mcc';
        $data['form_title'] = "[Date: " . date("F j, Y"). "]";
        return view('mailcancelledcases.MailCancelledCasesView', $data);
    }

    public function store(Request $request) {
         $this->validate($request, [
            //'emp_name' => 'required',
            'custID' => 'required',
            'contractID' => 'required',
            'email' => 'required',
            'prodID' => 'required',
            'date_cancelled' => 'required',
            'date_effect' => 'required',
            'reason' => 'required'
        ]);
        
        $insertData = array(
            'emp_name' => $request->get('emp_name'),
            'custID' => $request->get('custID'),
            'contractID' => $request->get('contractID'),
            'email' => $request->get('email'),
            'prodID' => $request->get('prodID'),
            'date_cancelled' => date('Y-m-d', strtotime($request->get('date_cancelled'))),
            'date_effect' => date('Y-m-d', strtotime($request->get('date_effect'))),
            'reason' => $request->get('reason')
        );
        
        $data['emp_name'] = Employee::where('uid', $request->get('emp_name'))->first();
        $data['custID'] = $request->get('custID');
        $data['contractID'] = $request->get('contractID');
        $data['email'] = $request->get('email');
        $data['prodID'] = $request->get('prodID');
        $data['date_cancelled'] = $request->get('date_cancelled');
        $data['date_effect'] = $request->get('date_effect');
        $data['reason'] = $request->get('reason');
       
        $user = Auth::user();
        Mail::send('mailcancelledcases.MailCancelledCasesSendMail', $data, function ($message) use ($user) {
           $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
           $message->to($user->superior->email, $user->superior->name)->subject('1&1 Mail.com Cancelled Cases');
           $message->cc($user->email, $user->name);
           $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
        });
        
        MailCancelledCases::create($insertData);
        Session::flash('flash_message', 'Case successfully added!');
        return redirect('mcc/newcase');
    }
    public function edit($id, Request $request){
        
        $breakdown = [
            'name' => '1&1 Mail.com Cancelled Cases',
            'headers' => ['Employee Name', 'Customer ID', 'Contract ID', 'Email Address', 'Case ID', 'Date Requested', 'Date Effect', 'Reason', 'Date Created'],
            'headerStyle' => ['','', '', '', '', '', '', '', ''],
            'data' => []
        ];
           
        $mcc = new MailCancelledCases();
        
        $data['data1'] = $mcc->where('id', $id)->first();
        $data['rows'] = $mcc->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = '1&1 Mail.com Cancelled Cases';
        $data['page_desc'] = 'Displays all cases created by the Mail.com team.';
        $data['perfurl'] = 'mcc';
        $data['form_title'] = "Your cases for " . date("F j, Y");
        return view('mailcancelledcases.MailCancelledCasesEdit', $data);
    
    }
    
    public function filter_date(Request $request){
        $date_from = $request->get('date_from');
        $from = date('Y-m-d', strtotime($date_from));
        $date_to = $request->get('date_to');
        $to = date('Y-m-d', strtotime($date_to));
        
        $mcc = new MailCancelledCases();
        $breakdown = [
            'name' => '1&1 Mail.com Cancelled Cases',
            'headers' => ['Employee Name', 'Customer ID', 'Contract ID', 'Email Address', 'Case ID', 'Date Requested', 'Date Effect', 'Reason', 'Date Created'],
            'headerStyle' => ['','', '', '', '', '', '', '', ''],
            'data' => []
        ];
        
        $data['all'] = $mcc->get();
        $data['rows'] = $mcc->where('created_at', '>=', $from)->where('updated_at', '<=', $to)->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = '1&1 Mail.com Cancelled Cases';
        $data['perfurl'] = 'mcc';

        return view('mailcancelledcases.MailCancelledCasesView', $data);
    }
    public function sort(){
        $mailcancelledcases = new MailCancelledCases();
        $breakdown = [
            'name' => '1&1 Mail.com Cancelled Cases',
            'headers' => ['Employee Name', 'Customer ID', 'Contract ID', 'Email Address', 'Case ID', 'Date Requested', 'Date Effect', 'Reason', 'Date Created'],
            'headerStyle' => ['','', '', '', '', '', '', '', ''],
            'data' => []
        ];
        
        if(isset($_POST['all'])){
            $data['rows'] = $mailcancelledcases->get();
        }
        if(isset($_POST['today'])){
            $today = date("Y-m-d");
            $data['rows'] = $mailcancelledcases->where('created_at', 'LIKE', "$today%")->get();
        }
        if(isset($_POST['monthly'])){
           $month = date("Y-m");
           $data['rows'] = $mailcancelledcases->where('created_at', 'LIKE', "$month%")->get();
        }
        if(isset($_POST['weekly'])){
           $today = date("Y-m-d");
           $week = date('W', strtotime($today));
           $data['rows'] = $mailcancelledcases->where('week', 'LIKE', "$week")->get();
        }
        
        $data['breakdown'] = $breakdown;
        $data['page_title'] = '1&1 Mail.com Cancelled Cases';
        $data['perfurl'] = 'mailcancelledcases';
        return view('mailcancelledcases.MailCancelledCasesView', $data);
    }
}                                                                                                       