<?php

namespace App\Http\Controllers;

use App\CancellationRequests;   
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Mail;
use Session;
use App\Employee as Employee;

class CancellationRequestsController extends Controller {
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
            'name' => 'Cancellation Requests',
            'headers' => ['Logged By', 'Customer ID', 'Contract ID', 'Email Address', 'Product ID', 'Date of Request', 'Date of Effect','Type','Reason'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];
        
        $cancellationrequests = new CancellationRequests();

        $data['rows'] = $cancellationrequests->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Cancellation Requests Tool';
        $data['perfurl'] = 'cancellationrequests';
        return view('cancellationrequests.cancellationrequestsview', $data);
    }
    
    public function store(Request $request) {
        
        $this->validate($request, 
            [   'customer_id' => 'required',
                'contract_id' => 'required',
                'product_id' => 'required',
                'cancellation_date' => 'required',
                'email' => 'required',
                'type' => 'required',
                'effective_date' => 'required',
                'reason' => 'required'
            ]
        );

        $holder = date('Y-m-d');
        $wkholder = date("W", strtotime($holder));
        $insertData = array(
            'name' =>$request->get('name'),
            'customer_id' =>$request->get('customer_id'),
            'contract_id' => $request->get('contract_id'),
            'product_id' => $request->get('product_id'),
            'cancellation_date' => date('Y-m-d', strtotime( $request->get('cancellation_date'))),
            'email' => $request->get('email'),
            'type' => $request->get('type'),
            'effective_date' => date('Y-m-d', strtotime( $request->get('effective_date'))),
            'reason' => $request->get('reason'),
            'week' => $wkholder
        );
            
            $data['name'] = Employee::where('uid', $request->get('name'))->first();
            $data['customer_id'] = $request->get('customer_id');
            $data['contract_id'] = $request->get('contract_id');
            $data['product_id'] = $request->get('product_id');
            $data['cancellation_date'] = $request->get('cancellation_date');
            $data['email'] = $request->get('email');
            $data['type'] = $request->get('type');
            $data['effective_date'] = $request->get('effective_date');
            $data['reason'] = $request->get('reason');
        
        CancellationRequests::create($insertData);
        Session::flash('flash_message', 'Request sent!');
            
        $user = Auth::user();
        Mail::send('cancellationrequests.cancellationssendfile', $data, function ($message) use ($user) {
            $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
            $message->to($user->superior->email, $user->superior->name)->subject('1&1 Cancellation Requests Tool');
            $message->cc($user->email, $user->name);
            $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
        });
            
        return redirect('cancellationrequests/create');
    }
    
    public function retrieve($id){
        $cancellationrequests = new CancellationRequests();
        $breakdown = [
            'name' => 'Cancellation Requests',
            'headers' => ['Logged By', 'Customer ID', 'Contract ID', 'Email Address', 'Product ID', 'Date of Request', 'Date of Effect','Type','Reason'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $data['temp'] = $cancellationrequests->where('id', $id)->first();
        $data['rows'] = $cancellationrequests->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Cancellation Requests Tool';
        $data['perfurl'] = 'cancellationrequests';
        return view('cancellationrequests.cancellationrequestsedit', $data);
    }
    
    
    public function sort(){
        $cancellationrequests = new CancellationRequests();
        $breakdown = [
            'name' => 'Cancellation Requests',
            'headers' => ['Logged By', 'Customer ID', 'Contract ID', 'Email Address', 'Product ID', 'Date of Request', 'Date of Effect','Type','Reason'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];
        
        if(isset($_POST['all'])){
            $data['rows'] = $cancellationrequests->get();
        }
        if(isset($_POST['today'])){
            $today = date("Y-m-d");
            $data['rows'] = $cancellationrequests->where('created_at', 'LIKE', "$today%")->get();
        }
        if(isset($_POST['monthly'])){
           $month = date("Y-m");
           $data['rows'] = $cancellationrequests->where('created_at', 'LIKE', "$month%")->get();
        }
        if(isset($_POST['weekly'])){
           $today = date("Y-m-d");
           $week = date('W', strtotime($today));
           $data['rows'] = $cancellationrequests->where('week', 'LIKE', "$week")->get();
        }
        
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Cancellation Requests Tool';
        $data['perfurl'] = 'cancellationrequests';
        return view('cancellationrequests.cancellationrequestsview', $data);
    }
    
    public function search(Request $request){
        $date_from = $request->get('date_from');
        $from = date('Y-m-d', strtotime($date_from));
        $date_to = $request->get('date_to');
        $to = date('Y-m-d', strtotime($date_to));
        
        $cancellationrequests = new CancellationRequests();
        $breakdown = [
            'name' => 'Cancellation Requests',
            'headers' => ['Logged By', 'Customer ID', 'Contract ID', 'Email Address', 'Product ID', 'Date of Request', 'Date of Effect','Type','Reason'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];
        
        $data['rows'] = CancellationRequests::where('created_at', '>=', "$from")->where('created_at', '<=', "$to")->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Cancellation Requests Tool';
        $data['perfurl'] = 'cancellationrequests';
        return view('cancellationrequests.cancellationrequestsview', $data);
    }
}
