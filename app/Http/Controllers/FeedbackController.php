<?php

namespace App\Http\Controllers;

use App\Feedback;   
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Mail;
use DB;
use Session;
use App\Employee as Employee;

class FeedbackController extends Controller {
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
    
    public function createform() {

        $breakdown = [
            'name' => 'Agent Feedbacks',
            'headers' => ['Email', 'Agent Involved', 'Other Agent Involved', 'Customer Number', 'Case ID'],
            'headerStyle' => ['', '', '', '', ''],
            'data' => []
        ];
        
        $feedback = new Feedback();

        $data['agent'] = DB::table('employees')->select(DB::raw('*'))->where('active', '=', 1)->where('departmentid', '=', 21386574)->orWhere('departmentid', '=', 21440028)->get();
        $data['rows'] = $feedback->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Mail.com Agent Feedback Tool';
        $data['perfurl'] = 'feedback';
        return view('feedback.feedbackview', $data);
    }
    
    public function store(Request $request) {
        
        $this->validate($request, 
            [   'email' => 'required',
                'agent' => 'required',
                'other_agent' => 'required',
                'customer_number' => 'required',
                'case_id' => 'required',
                'problem' => 'required',
                'solution' => 'required'
            ]
        );

        $holder = date('Y-m-d');
        $wkholder = date("W", strtotime($holder));
        $insertData = array(
            'email' => $request->get('email'),
            'agent' =>$request->get('agent'),
            'other_agent' => $request->get('other_agent'),
            'customer_number' =>$request->get('customer_number'),
            'case_id' => $request->get('case_id'),
            'problem' => $request->get('problem'),
            'solution' => $request->get('solution'),
            'week' => $wkholder
        );
            
            $data['email'] = $request->get('email');
            $data['agent'] = $request->get('agent');
            $data['other_agent'] = $request->get('other_agent');
            $data['customer_number'] = $request->get('customer_number');
            $data['case_id'] = $request->get('case_id');
            $data['problem'] = $request->get('problem');
            $data['solution'] = $request->get('solution');
        
        Feedback::create($insertData);
        Session::flash('flash_message', 'Feedback added!');   
         
        $user = Auth::user();
        Mail::send('feedback.feedbacksendfile', $data, function ($message) use ($user) {
            $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
            $message->to($user->superior->email, $user->superior->name)->subject('1&1 Mail.com Agent Feedback Tool');
            $message->cc($user->email, $user->name);
            $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
        });
       
       return redirect('feedback/create');
    }
    
    public function retrieve($id){
        $breakdown = [
            'name' => 'Agent Feedbacks',
            'headers' => ['Email', 'Agent Involved', 'Other Agent Involved', 'Customer Number', 'Case ID'],
            'headerStyle' => ['', '', '', '', ''],
            'data' => []
        ];
        
        $feedback = new Feedback();
        
        $data['temp'] = $feedback->where('id', $id)->first();
        $data['agent'] = DB::table('employees')->select(DB::raw('*'))->where('active', '=', 1)->where('departmentid', '=', 21386574)->orWhere('departmentid', '=', 21440028)->get();
        $data['rows'] = $feedback->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Mail.com Agent Feedback Tool';
        $data['perfurl'] = 'feedback';
        return view('feedback.feedbackedit', $data);
    }
    
    public function sort(){
        $breakdown = [
            'name' => 'Agent Feedbacks',
            'headers' => ['Email', 'Agent Involved', 'Other Agent Involved', 'Customer Number', 'Case ID'],
            'headerStyle' => ['', '', '', '', ''],
            'data' => []
        ];
        
        $feedback = new Feedback();
        
        if(isset($_POST['all'])){
            $data['rows'] = $feedback->get();
        }
        if(isset($_POST['today'])){
            $today = date("Y-m-d");
            $data['rows'] = $feedback->where('created_at', 'LIKE', "$today%")->get();
        }
        if(isset($_POST['monthly'])){
           $month = date("Y-m");
           $data['rows'] = $feedback->where('created_at', 'LIKE', "$month%")->get();
        }
        if(isset($_POST['weekly'])){
           $today = date("Y-m-d");
           $week = date('W', strtotime($today));
           $data['rows'] = $feedback->where('week', 'LIKE', "$week")->get();
        }
        
        $data['agent'] = DB::table('employees')->select(DB::raw('*'))->where('active', '=', 1)->where('departmentid', '=', 21386574)->orWhere('departmentid', '=', 21440028)->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Mail.com Agent Feedback Tool';
        $data['perfurl'] = 'feedback';
        return view('feedback.feedbackview', $data);
    }
    
    public function search(Request $request){
        $date_from = $request->get('date_from');
        $from = date('Y-m-d', strtotime($date_from));
        $date_to = $request->get('date_to');
        $to = date('Y-m-d', strtotime($date_to));
        
        $breakdown = [
            'name' => 'Agent Feedbacks',
            'headers' => ['Email', 'Agent Involved', 'Other Agent Involved', 'Customer Number', 'Case ID'],
            'headerStyle' => ['', '', '', '', ''],
            'data' => []
        ];
        
        $feedback = new Feedback();
        
        $data['agent'] = DB::table('employees')->select(DB::raw('*'))->where('active', '=', 1)->where('departmentid', '=', 21386574)->orWhere('departmentid', '=', 21440028)->get();
        $data['rows'] = Feedback::where('created_at', '>=', "$from")->where('created_at', '<=', "$to")->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Mail.com Agent Feedback Tool';
        $data['perfurl'] = 'feedback';
        return view('feedback.feedbackview', $data);
    }
}
