<?php

namespace App\Http\Controllers;

use App\Debriefing;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Mail;
use Session;
use App\Employee as Employee;

class DebriefingController extends Controller {
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
            'name' => 'Debriefing Reports',
            'headers' => ['Created By', 'Type of Report', 'Category', 'Date', 'Shift Schedule', 'Status'],
            'headerStyle' => ['', '', '', '', '', ''],
            'data' => []
        ];
        
        $debriefing = new Debriefing();
        
        $data['all'] = $debriefing->get();
        $data['rows'] = $debriefing->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Debriefing Reports';
        $data['perfurl'] = 'debriefing';
        return view('debriefing.debriefingview', $data);
    }
    public function index(){
        return $this->createform();
    }


    public function store(Request $request) {
        
       $holder = date('Y-m-d');
       $wkholder = date("W", strtotime($holder));
        
        if(isset($_POST['save'])){
            $insertData = array(
                'name' => $request->get('name'),
                'reporttype' => $request->get('reporttype'),
                'category' => $request->get('category'),
                'shift' => $request->get('shift'),
                'content' => $request->get('content'),
                'status' => "Unsent",
                'week' => $wkholder
            );
            Debriefing::create($insertData);
            Session::flash('flash_message', 'Saved as draft!');
            return redirect('debriefing/create');
        }
        
        if(isset($_POST['send'])){
            $this->validate($request, [   
                'name' => 'required',
                'reporttype' => 'required',
                'category' => 'required',
                'shift' => 'required',
                'content' => 'required'
            ]);
            
            $insertData = array(
                'name' => $request->get('name'),
                'reporttype' => $request->get('reporttype'),
                'category' => $request->get('category'),
                'shift' => $request->get('shift'),
                'content' => $request->get('content'),
                'status' => "Sent",
                'week' => $wkholder
            );
            
            Debriefing::create($insertData);
            Session::flash('flash_message', 'Sent successfully!');
            
           $data['name'] = Employee::where('uid', $request->get('name'))->first();
           $data['reporttype'] = $request->get('reporttype');
           $data['category'] = $request->get('category');
           $data['shift'] = $request->get('shift');
           $data['content'] = $request->get('content');

           $user = Auth::user();
           Mail::send('debriefing.debriefingsendfile', $data, function ($message) use ($user) {
               $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
               $message->to('tristan.curtin@1and1.com', 'Tristan Curtin')->subject('1&1 Debriefing Report');
               $message->cc($user->email, $user->name);
               $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
           });
           
           return redirect('debriefing/create');
        }
        
        if(isset($_POST['save_myrep'])){
            $insertData = array(
                'name' => $request->get('name'),
                'reporttype' => $request->get('reporttype'),
                'category' => $request->get('category'),
                'shift' => $request->get('shift'),
                'content' => $request->get('content'),
                'status' => "Unsent",
                'week' => $wkholder
            );
            Debriefing::create($insertData);
            Session::flash('flash_message', 'Saved as draft!');
            return redirect('debriefing/myreports');
         }
         
        if(isset($_POST['send_myrep'])){
            
            $this->validate($request, [   
                'name' => 'required',
                'reporttype' => 'required',
                'category' => 'required',
                'shift' => 'required',
                'content' => 'required'
            ]);
            
            $insertData = array(
                'name' => $request->get('name'),
                'reporttype' => $request->get('reporttype'),
                'category' => $request->get('category'),
                'shift' => $request->get('shift'),
                'content' => $request->get('content'),
                'status' => "Sent",
                'week' => $wkholder
            );
            
            Debriefing::create($insertData);
            Session::flash('flash_message', 'Sent successfully!');
            
           $data['name'] = Employee::where('uid', $request->get('name'))->first();
           $data['reporttype'] = $request->get('reporttype');
           $data['category'] = $request->get('category');
           $data['shift'] = $request->get('shift');
           $data['content'] = $request->get('content');

           $user = Auth::user();
           Mail::send('debriefing.debriefingsendfile', $data, function ($message) use ($user) {
               $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
               $message->to('tristan.curtin@1and1.com', 'Tristan Curtin')->subject('1&1 Debriefing Report');
               $message->cc($user->email, $user->name);
               $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
           });
           
           return redirect('debriefing/myreports');
        }
         
    }
    
    public function retrieve($id){
        $debriefing = new Debriefing();
        $breakdown = [
            'name' => 'Debriefing Reports',
            'data' => []
        ];

        $data['temp'] = $debriefing->where('id', $id)->first();
        $data['rows'] = $debriefing->get();
        $data['all'] = $debriefing->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Debriefing Reports';
        $data['perfurl'] = 'debriefing';

        return view('debriefing.debriefingedit', $data);
    }
    
    public function display($id){
        $debriefing = new Debriefing();
        $breakdown = [
            'name' => 'Debriefing Reports',
            'data' => []
        ];

        $data['temp'] = $debriefing->where('id', $id)->first();
        $data['rows'] = $debriefing->get();
        $data['all'] = $debriefing->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Debriefing Reports';
        $data['perfurl'] = 'debriefing';

        return view('debriefing.debriefingdisplay', $data);
    }
    
    public function update(Request $request){
        
        $holder = date('Y-m-d');
        $wkholder = date("W", strtotime($holder));
        
        if(isset($_POST['save'])){
            $updateData = array(
            'name' => $request->get('name'),
            'reporttype' => $request->get('reporttype'),
            'category' => $request->get('category'),
            'shift' => $request->get('shift'),
            'content' => $request->get('content'),
            'status' => 'Unsent',
            'week' => $wkholder

            );
            $debriefing = Debriefing::find($request->get('id'));
            $debriefing->update($updateData);
            Session::flash('flash_message', 'Saved as draft!');
            return redirect('debriefing/myreports');
         }
        if(isset($_POST['send'])){
            $this->validate($request,  [
                'name' => 'required',
                'reporttype' => 'required',
                'category' => 'required',
                'shift' => 'required',
                'content' => 'required'
             ]);
            
            $updateData = array(
            'name' => $request->get('name'),
            'reporttype' => $request->get('reporttype'),
            'category' => $request->get('category'),
            'shift' => $request->get('shift'),
            'content' => $request->get('content'),
            'status' => 'Sent',
            'week' => $wkholder

            );
            $debriefing = Debriefing::find($request->get('id'));
            $debriefing->update($updateData);
            
           $data['name'] = Employee::where('uid', $request->get('name'))->first();
           $data['reporttype'] = $request->get('reporttype');
           $data['category'] = $request->get('category');
           $data['shift'] = $request->get('shift');
           $data['content'] = $request->get('content');

           $user = Auth::user();
           Mail::send('debriefing.debriefingsendfile', $data, function ($message) use ($user) {
               $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
               $message->to('tristan.curtin@1and1.com', 'Tristan Curtin')->subject('1&1 Debriefing Report');
               $message->cc($user->email, $user->name);
               $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
           });
           Session::flash('flash_message', 'Sent successfully!');
           return redirect('debriefing/myreports');
        }
        
    }
    
    
    public function view(){
        $debriefing = new Debriefing();
        $breakdown = [
            'name' => 'Debriefing Reports',
            'headers' => ['Created By', 'Type of Report', 'Category', 'Date', 'Shift Schedule', 'Status'],
            'headerStyle' => ['', '', '', '', '', ''],
            'data' => []
        ];
        
        if(isset($_POST['all'])){
            $data['rows'] = $debriefing->get();
        }
        if(isset($_POST['today'])){
            $today = date("Y-m-d");
            $data['rows'] = $debriefing->where('created_at', 'LIKE', "$today%")->get();
        }
        if(isset($_POST['monthly'])){
           $month = date("Y-m");
           $data['rows'] = $debriefing->where('created_at', 'LIKE', "$month%")->get();
        }
        if(isset($_POST['weekly'])){
           $today = date("Y-m-d");
           $week = date('W', strtotime($today));
           $data['rows'] = $debriefing->where('week', 'LIKE', "$week")->get();
        }
        $data['all'] = $debriefing->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Debriefing Reports';
        $data['perfurl'] = 'debriefing';

        return view('debriefing.debriefingview', $data);
    }
    
    public function search(Request $request){
        $date_from = $request->get('date_from');
        $from = date('Y-m-d', strtotime($date_from));
        $date_to = $request->get('date_to');
        $to = date('Y-m-d', strtotime($date_to));
        
        $debriefing = new Debriefing();
        $breakdown = [
            'name' => 'Debriefing Reports',
            'headers' => ['Created By', 'Type of Report', 'Category', 'Date', 'Shift Schedule', 'Status'],
            'headerStyle' => ['', '', '', '', '', ''],
            'data' => []
        ];
        $data['all'] = $debriefing->get();
        $data['rows'] = Debriefing::where('created_at', '>=', "$from")->where('created_at', '<=', "$to")->get();
//        $data['rows'] = Debriefing::whereBetween('date', array($from, $to))->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Debriefing Reports';
        $data['perfurl'] = 'debriefing';

        return view('debriefing.debriefingview', $data);
    }
    
    public function myreports(){
        $breakdown = [
            'name' => 'Your Reports',
            'headers' => ['Created By', 'Type of Report', 'Category', 'Date', 'Shift Schedule', 'Status'],
            'headerStyle' => ['', '', '', '', '', ''],
            'data' => []
        ];
        
        $debriefing = new Debriefing();
        
        $data['all'] = $debriefing->get();
        $data['rows'] = $debriefing->where('name', 'LIKE', Auth::user()->uid)->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Debriefing Reports';
        $data['perfurl'] = 'debriefing';
        return view('debriefing.debriefingmyreports', $data);
        
    }
    
    public function reports(){
        $debriefing = new Debriefing();
        $breakdown = [
            'name' => 'Debriefing Reports',
            'headers' => ['Created By', 'Type of Report', 'Category', 'Date', 'Shift Schedule', 'Status'],
            'headerStyle' => ['', '', '', '', '', ''],
            'data' => []
        ];
        
        if(isset($_POST['all'])){
            $data['rows'] = $debriefing->where('name', 'LIKE', Auth::user()->uid)->get();
        }
        if(isset($_POST['today'])){
            $today = date("Y-m-d");
            $data['rows'] = $debriefing->where('name', 'LIKE', Auth::user()->uid)->where('created_at', 'LIKE', "$today%")->get();
        }
        if(isset($_POST['monthly'])){
           $month = date("Y-m");
           $data['rows'] = $debriefing->where('name', 'LIKE', Auth::user()->uid)->where('created_at', 'LIKE', "$month%")->get();
        }
        if(isset($_POST['weekly'])){
           $today = date("Y-m-d");
           $week = date('W', strtotime($today));
           $data['rows'] = $debriefing->where('name', 'LIKE', Auth::user()->uid)->where('week', 'LIKE', "$week")->get();
        }
        $data['all'] = $debriefing->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Debriefing Reports';
        $data['perfurl'] = 'debriefing';

        return view('debriefing.debriefingmyreports', $data);
    }
    public function searchdate(Request $request){
        $date_from = $request->get('date_from');
        $from = date('Y-m-d', strtotime($date_from));
        $date_to = $request->get('date_to');
        $to = date('Y-m-d', strtotime($date_to));
        
        $debriefing = new Debriefing();
        $breakdown = [
            'name' => 'Debriefing Reports',
            'headers' => ['Created By', 'Type of Report', 'Category', 'Date', 'Shift Schedule', 'Status'],
            'headerStyle' => ['', '', '', '', '', ''],
            'data' => []
        ];
        $data['all'] = $debriefing->get();
        $data['rows'] = $debriefing->where('name', 'LIKE', Auth::user()->uid)->where('created_at', '>=', "$from")->where('created_at', '<=', "$to")->get();
//        $data['rows'] = Debriefing::whereBetween('date', array($from, $to))->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Debriefing Reports';
        $data['perfurl'] = 'debriefing';

        return view('debriefing.debriefingmyreports', $data);
    }
}
