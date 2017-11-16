<?php

namespace App\Http\Controllers;

use App\Freemailers;   
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Mail;
use Session;
use App\Employee as Employee;

class FreemailersController extends Controller {
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
            'name' => 'Free Mailers',
            'headers' => ['Case ID', 'Employee Name', 'Customer ID', 'Email Address', 'Medium', 'Date', 'Reasons'],
            'headerStyle' => ['', '', '', '', '', '', ''],
            'data' => []
        ];
        
        $freemailers = new Freemailers();

        $data['rows'] = $freemailers->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Freemailers Tracking Tool';
        $data['perfurl'] = 'freemailers';
        return view('freemailers.freemailersview', $data);
    }

        public function store(Request $request) {
        
        $this->validate($request, 
            [   'customer_id' => 'required',
                'case_id' => 'required',
                'medium' => 'required',
                'email' => 'required',
                'description' => 'required'
            ]
        );

        $holder = date('Y-m-d');
        $wkholder = date("W", strtotime($holder));
        $insertData = array(
            'name' =>$request->get('name'),
            'customer_id' =>$request->get('customer_id'),
            'case_id' => $request->get('case_id'),
            'medium' => $request->get('medium'),
            'email' => $request->get('email'),
            'description' => $request->get('description'),
            'week' => $wkholder
        );
            
            $data['name'] = Employee::where('uid', $request->get('name'))->first();
            $data['customer_id'] = $request->get('customer_id');
            $data['case_id'] = $request->get('case_id');
            $data['medium'] = $request->get('medium');
            $data['email'] = $request->get('email');
            $data['description'] = $request->get('description');
            
            Freemailers::create($insertData);
            Session::flash('flash_message', 'Case added!');
            
            $user = Auth::user();
            Mail::send('freemailers.freemailerssendfile', $data, function ($message) use ($user) {
                $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
                $message->to($user->superior->email, $user->superior->name)->subject('1&1 Freemailers Tracking Tool');
                $message->cc($user->email, $user->name);
                $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
            });
       
        return redirect('freemailers/create');
    }
    
    public function retrieve($id){
        $freemailers= new Freemailers();
        $breakdown = [
            'name' => 'Free Mailers',
            'headers' => ['Case ID', 'Employee Name', 'Customer ID', 'Email Address', 'Medium', 'Date', 'Reasons'],
            'headerStyle' => ['', '', '', '', '', '', ''],
            'data' => []
        ];

        $data['temp'] = $freemailers->where('id', $id)->first();
        $data['rows'] = $freemailers->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Freemailers Tracking Tool';
        $data['perfurl'] = 'freemailers';
        return view('freemailers.freemailersedit', $data);
    }
    
    public function search(Request $request){
        $date_from = $request->get('date_from');
        $from = date('Y-m-d', strtotime($date_from));
        $date_to = $request->get('date_to');
        $to = date('Y-m-d', strtotime($date_to));
        
        $freemailers = new Freemailers();
        $breakdown = [
            'name' => 'Free Mailers',
            'headers' => ['Case ID', 'Employee Name', 'Customer ID', 'Email Address', 'Medium', 'Date', 'Reasons'],
            'headerStyle' => ['', '', '', '', '', '', ''],
            'data' => []
        ];
        
        $data['rows'] = Freemailers::where('created_at', '>=', "$from")->where('created_at', '<=', "$to")->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Freemailers Tracking Tool';
        $data['perfurl'] = 'freemailers';
        return view('freemailers.freemailersview', $data);
    }
    
    public function sort(){
        $freemailers = new Freemailers();
        $breakdown = [
            'name' => 'Free Mailers',
            'headers' => ['Case ID', 'Employee Name', 'Customer ID', 'Email Address', 'Medium', 'Date', 'Reasons'],
            'headerStyle' => ['', '', '', '', '', '', ''],
            'data' => []
        ];
        
        if(isset($_POST['all'])){
            $data['rows'] = $freemailers->get();
        }
        if(isset($_POST['today'])){
            $today = date("Y-m-d");
            $data['rows'] = $freemailers->where('created_at', 'LIKE', "$today%")->get();
        }
        if(isset($_POST['monthly'])){
           $month = date("Y-m");
           $data['rows'] = $freemailers->where('created_at', 'LIKE', "$month%")->get();
        }
        if(isset($_POST['weekly'])){
           $today = date("Y-m-d");
           $week = date('W', strtotime($today));
           $data['rows'] = $freemailers->where('week', 'LIKE', "$week")->get();
        }
        
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Freemailers Tracking Tool';
        $data['perfurl'] = 'freemailers';
        return view('freemailers.freemailersview', $data);
    }
}
