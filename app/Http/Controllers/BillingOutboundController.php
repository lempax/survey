<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use Mail;
use App\Employee;
use App\Department;
use App\BillingOutbound;


class BillingOutboundController extends Controller
{
    
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
            'name' => 'Billing Outbound Tracking Tool',
            'headers' => ['Logged By', 'Customer ID', 'Contract ID', 'Case ID', 'Notes', 'Date', 'Remarks','Timestamp'],
            'headerStyle' => ['', '', '', '', '', '', '', ''],
            'data' => []
        ];
        
        $billingoutbound = new BillingOutbound();

        $data['rows'] = $billingoutbound->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Billing Outbound Tracking Tool';
        $data['perfurl'] = 'billingoutbound';
        return view('billingoutbound.billingoutboundview', $data);
    }
    
    public function store(Request $request) {
        
        $this->validate($request, 
            [   'custid' => 'required',
                'contractid' => 'required',
                'caseid' => 'required'  
            ]
        );

        $holder = date('Y-m-d');
        $wkholder = date("W", strtotime($holder));
        $insertData = array(
            'user' =>$request->get('user'),
            'custid' =>$request->get('custid'),
            'contractid' => $request->get('contractid'),
            'caseid' => $request->get('caseid'),
            'notes' => $request->get('notes'),
            'date' => date('Y-m-d', strtotime( $request->get('date'))),
            'timestamp' => date('Y-m-d', strtotime( $request->get('timestamp'))),
            'remarks' => $request->get('remarks'),
            'week' => $wkholder
        );
            
            $data['user'] = Employee::where('username', $request->user)->where('active', 1)->first();
//                    Employee::where('uid', $request->get('name'))->first();
            $data['custid'] = $request->get('custid');
            $data['contractid'] = $request->get('contractid');
            $data['caseid'] = $request->get('caseid');
            $data['notes'] = $request->get('notes');
            $data['date'] = $request->get('date');
            $data['remarks'] = $request->get('remarks');
            $data['timestamp'] = $request->get('timestamp');
        
        BillingOutbound::create($insertData);
        Session::flash('flash_message', 'Request sent!');
            
        $user = Auth::user();
        Mail::send('billingoutbound.billingoutboundfile', $data, function ($message) use ($user) {
            $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
            $message->to($user->superior->email, $user->superior->name)->subject('1&1 Billing Outbound Tracking Tool');
            $message->cc($user->email, $user->name);
            $message->bcc('leslie.benigra@1and1.com', 'Leslie Benigra');
       }
       );            
        return redirect('billingoutbound/create');
    }
    
    public function retrieve($id){
        $billingoutbound = new BillingOutbound();
        $breakdown = [
            'name' => 'Billing Outbound Tracking Tool',
            'headers' => ['Logged By', 'Customer ID', 'Contract ID', 'Case ID', 'Notes', 'Date', 'Remarks','Timestamp'],
            'headerStyle' => ['', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $data['id'] = $id;
        $data['temp'] = $billingoutbound->where('id', $id)->first();
        $data['rows'] = $billingoutbound->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Billing Outbound Tracking Tool';
        $data['perfurl'] = 'billingoutbound';
        return view('billingoutbound.billingoutboundedit', $data);
    }
    
    public function update(Request $request,$id){
    
          $holder = date('Y-m-d');
            $wkholder = date("W", strtotime($holder));
            $updateData = array(
                'user' =>$request->get('user'),
                'custid' =>$request->get('custid'),
                'contractid' => $request->get('contractid'),
                'caseid' => $request->get('caseid'),
                'notes' => $request->get('notes'),
                'date' => date('Y-m-d', strtotime( $request->get('date'))),
                'timestamp' => date('Y-m-d', strtotime( $request->get('timestamp'))),
                'remarks' => $request->get('remarks'),
                'week' => $wkholder
            );  
            
           BillingOutbound::where('id',$id)->update($updateData);
           return redirect('billingoutbound/create');

    }

        public function sort(){
        $billingoutbound = new BillingOutbound();
        $breakdown = [
            'name' => 'Billing Outbound Tracking Tool',
            'headers' => ['Logged By', 'Customer ID', 'Contract ID', 'Case ID', 'Notes', 'Date', 'Remarks','Timestamp'],
            'headerStyle' => ['', '', '', '', '', '', '', ''],
            'data' => []
        ];
        
        if(isset($_POST['all'])){
            $data['rows'] = $billingoutbound->get();
        }
        if(isset($_POST['today'])){
            $today = date("Y-m-d");
            $data['rows'] = $billingoutbound->where('date', 'LIKE', "$today%")->get();
        }
        if(isset($_POST['monthly'])){
           $month = date("Y-m");
           $data['rows'] = $billingoutbound->where('date', 'LIKE', "$month%")->get();
        }
        if(isset($_POST['weekly'])){
           $today = date("Y-m-d");
           $week = date('W', strtotime($today));
           $data['rows'] = $billingoutbound->where('week', 'LIKE', "$week")->get();
        }
        
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Billing Outbound Tracking Tool';
        $data['perfurl'] = 'billingoutbound';
        return view('billingoutbound.billingoutboundview', $data);
    }
    
    public function search(Request $request){
        $date_from = $request->get('date_from');
        $from = date('Y-m-d', strtotime($date_from));
        $date_to = $request->get('date_to');
        $to = date('Y-m-d', strtotime($date_to));
        
        $billingoutbound = new BillingOutbound();
        $breakdown = [
            'name' => 'Billing Outbound Tracking Tool',
            'headers' => ['Logged By', 'Customer ID', 'Contract ID', 'Case ID', 'Notes', 'Date', 'Remarks','Timestamp'],
            'headerStyle' => ['', '', '', '', '', '', '', ''],
            'data' => []
        ];
        
        $data['rows'] = BillingOutbound::where('date', '>=', "$from")->where('date', '<=', "$to")->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Billing Outbound Tracking Tool';
        $data['perfurl'] = 'billingoutbound';
        return view('billingoutbound.billingoutboundview', $data);
    }
}
