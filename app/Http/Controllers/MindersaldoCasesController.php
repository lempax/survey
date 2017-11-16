<?php

namespace App\Http\Controllers;

use App\MindersaldoCases;   
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Mail;
use Session;
use App\Employee as Employee;

class MindersaldoCasesController extends Controller {
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
            'name' => '1&1 Mindersaldo Cases Tracking Tool',
            'headers' => ['Logged By', 'SSE Customer ID', 'Contract ID', 'Date and Time Created'],
            'headerStyle' => ['', '', '', ''],
            'data' => []
        ];
        
        $mindersaldocases = new MindersaldoCases();

        $data['rows'] = $mindersaldocases->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = '1&1 Mindersaldo Cases Tracking Tool';
        $data['perfurl'] = 'mct';
        return view('mindersaldocases.MindersaldoCasesView', $data);
    }
    
    public function store(Request $request) {
        
        $this->validate($request, 
            [   'customer_id' => 'required',
                'contract_id' => 'required',
                'date_updated' => 'required',
                'date_mindersaldo_lock' => 'required',
                'confirm' => 'required'
            ]
        );

        $holder = date('Y-m-d');
        $wkholder = date("W", strtotime($holder));
        $insertData = array(
            'emp_name' =>$request->get('emp_name'),
            'customer_id' =>$request->get('customer_id'),
            'contract_id' => $request->get('contract_id'),
            'date_updated' => date('Y-m-d', strtotime( $request->get('date_updated'))),
            'date_mindersaldo_lock' => date('Y-m-d', strtotime( $request->get('date_mindersaldo_lock'))),
            'confirm' => $request->get('confirm'),
            'week' => $wkholder
        );
            
            $data['emp_name'] = Employee::where('uid', $request->get('emp_name'))->first();
            $data['customer_id'] = $request->get('customer_id');
            $data['contract_id'] = $request->get('contract_id');
            $data['date_updated'] = $request->get('date_updated');
            $data['date_mindersaldo_lock'] = $request->get('date_mindersaldo_lock');
            $data['confirm'] = $request->get('confirm');
                       
        $user = Auth::user();
        Mail::send('mindersaldocases.MindersaldoCasesSendMail', $data, function ($message) use ($user) {
            $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
           $message->to($user->superior->email, $user->superior->name)->subject('1&1 Mindersaldo Cases Tracking Tool');
           $message->cc($user->email, $user->name);
           $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
        });
            
            
        MindersaldoCases::create($insertData);
        Session::flash('flash_message', 'Case successfully added!');
        return redirect('mct/newcase');
    }
    
    public function retrieve($id){
        $mindersaldocases = new MindersaldoCases();
        $breakdown = [
            'name' => '1&1 Mindersaldo Cases Tracking Tool',
            'headers' => ['Logged By', 'SSE Customer ID', 'Contract ID', 'Date and Time Created'],
            'headerStyle' => ['', '', '', ''],
            'data' => []
        ];

        $data['data1'] = $mindersaldocases->where('id', $id)->first();
        $data['rows'] = $mindersaldocases->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Mindersaldo Cases Tracking Tool';
        $data['perfurl'] = 'mct';
        return view('mindersaldocases.MindersaldoCasesEdit', $data);
    }
    
    public function sort(){
        $mindersaldocases = new MindersaldoCases();
        $breakdown = [
            'name' => '1&1 Mindersaldo Cases Tracking Tool',
            'headers' => ['Logged By', 'SSE Customer ID', 'Contract ID', 'Date and Time Created'],
            'headerStyle' => ['', '', '', ''],
            'data' => []
        ];
        
        if(isset($_POST['all'])){
            $data['rows'] = $mindersaldocases->get();
        }
        if(isset($_POST['today'])){
            $today = date("Y-m-d");
            $data['rows'] = $mindersaldocases->where('created_at', 'LIKE', "$today%")->get();
        }
        if(isset($_POST['monthly'])){
           $month = date("Y-m");
           $data['rows'] = $mindersaldocases->where('created_at', 'LIKE', "$month%")->get();
        }
        if(isset($_POST['weekly'])){
           $today = date("Y-m-d");
           $week = date('W', strtotime($today));
           $data['rows'] = $mindersaldocases->where('week', 'LIKE', "$week")->get();
        }
        
        $data['breakdown'] = $breakdown;
        $data['page_title'] = '1&1 Mindersaldo Cases Tracking Tool';
        $data['perfurl'] = 'mindersaldocases';
        return view('mindersaldocases.MindersaldoCasesView', $data);
    }
    
    public function search(Request $request){
        $date_from = $request->get('date_from');
        $from = date('Y-m-d', strtotime($date_from));
        $date_to = $request->get('date_to');
        $to = date('Y-m-d', strtotime($date_to));
        
        $mindersaldocases = new MindersaldoCases();
        $breakdown = [
            'name' => '1&1 Mindersaldo Cases Tracking Tool',
            'headers' => ['Logged By', 'SSE Customer ID', 'Contract ID', 'Date and Time Created'],
            'headerStyle' => ['', '', '', ''],
            'data' => []
        ];
        
        $data['rows'] = MindersaldoCases::where('created_at', '>=', "$from")->where('created_at', '<=', "$to")->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = '1&1 Mindersaldo Cases Tracking Tool';
        $data['perfurl'] = 'mct';
        return view('mindersaldocases.MindersaldoCasesView', $data);
    }
}
