<?php

namespace App\Http\Controllers;

use App\RetentionCase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use Auth;
use Session;
use App\Employee as Employee;

class RetentionCaseController extends Controller {

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
                'name' => 'Retention Case',
                'headers' => ['ID', 'Logged By', 'Customer ID', 'Contract ID', 'Date of Retention', 'Date of Submitted','Status'],
                'headerStyle' => ['', '','', '', '', '', ''],
                'data' => []
            ];

            $retentioncase = new RetentionCase();
            $data['rows'] = $retentioncase->get();
            $data['breakdown'] = $breakdown;
            $data['page_title'] = '1&1 Retention Tracking Tool';
            $data['page_desc'] = 'Displays all retention cases.';
            $data['perfurl'] = 'retentioncase';
            $data['form_title'] = "Your cases for " . date("F j, Y");
            return view('retentioncase.RetentionCaseView', $data);
        }

        public function store(Request $request) {
            $this->validate($request, [
                    'loggedby' => 'required',
                    'customer_id' => 'required',
                    'contract_id' => 'required||integer',
                    'email_address' => 'required',
                    'date' => 'required',
                    'current_price' => 'required',
                    'price_offered' => 'required',
                    'status' => 'required'
            ]);
            
//            $file = Request::file('files');
//            $extension = $file->getClientOriginalExtension();
//            Storage::disk('local')->put($file->getFilename().'.'.$extension,  File::get($file));
//		$entry = new BugRequest();
//		$entry->mime = $file->getClientMimeType();
//		$entry->original_filename = $file->getClientOriginalName();
//		$entry->filename = $file->getFilename().'.'.$extension;
            
            $insertData = array(
                'loggedby' => $request->get('loggedby'),
                'customer_id' => $request->get('customer_id'),
                'contract_id' => $request->get('contract_id'),
                'email_address' => $request->get('email_address'),
                'date' => date('Y-m-d', strtotime($request->get('date'))),
                'current_price' => $request->get('current_price'),
                'price_offered' => $request->get('price_offered'),
                'status' => $request->get('status')
            );
            
                if(isset($_POST['send'])){
                RetentionCase::create($insertData);
                $data['loggedby'] = $request->get('loggedby');  
                $data['id'] = $request->get('id');
                $data['customer_id'] = $request->get('customer_id');
                $data['contract_id'] = $request->get('contract_id');
                $data['email_address'] = $request->get('email_address');
                $data['date'] = $request->get('date');
                $data['current_price'] = $request->get('current_price');
                $data['price_offered'] = $request->get('price_offered');
                $data['status'] = $request->get('status');

//            $user = Auth::user();
//            Mail::send('retentioncase.RetentionCaseSendFile', $data, function ($message) use ($user) {
//                $message->from('no-reply@mis-ews.ph.schlund.net', '1&1 Retention Case Tracking Tool');
//                $message->to('sarahmae.navales@1and1.com')->subject('1&1 Retention Case');
//                $message->cc($user->email, $user->name);
//                $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
//            });
                return view('retentioncase.RetentionCaseSendFile',$data);
                }
                     
            Session::flash('flash_message', 'Successfully Added!');
            return redirect('retentioncase/create');
            
    }
        
        public function edit($id){
            
            $breakdown = [
                    'name' => 'Retention Case',
                    'headers' => ['ID', 'Logged By', 'Customer ID', 'Contract ID', 'Date of Retention', 'Date of Submitted','Status'],
                    'headerStyle' => ['', '','', '', '', '', ''],
                    'data' => []
            ];
            
            $retentioncase = new RetentionCase();
            $data['temp'] = $retentioncase->where('id', $id)->first();
            $data['rows'] = $retentioncase->get();
            $data['breakdown'] = $breakdown;
            $data['page_title'] = '1&1 Retention Tracking Tool';
            $data['page_desc'] = 'Display all retention cases';
            $data['perfurl'] = 'retentioncase';
            $data['form_title'] = "Your cases for " . date("F j, Y");
            return view('retentioncase.RetentionCaseEdit', $data);

        }
        
        public function update(Request $request){
            
             $this->validate($request, [
                    'loggedby' => 'required',
                    'customer_id' => 'required',
                    'contract_id' => 'required||integer',
                    'email_address' => 'required',
                    'date' => 'required',
                    'current_price' => 'required',
                    'price_offered' => 'required',
                    'status' => 'required'
            ]);

            $updateData = array(
                'loggedby' => $request->get('loggedby'),
                'customer_id' => $request->get('customer_id'),
                'contract_id' => $request->get('contract_id'),
                'email_address' => $request->get('email_address'),
                'date' => date('Y-m-d', strtotime($request->get('date'))),
                'current_price' => $request->get('current_price'),
                'price_offered' => $request->get('price_offered'),
                'status' => $request->get('status')
            );
                
                if(isset($_POST['save'])){
                $retentioncase = RetentionCase::find($request->get('id'));
                $retentioncase->update($updateData);
                }
                if(isset($_POST['send'])){     
                $data['loggedby'] = $request->get('loggedby');  
                $data['id'] = $request->get('id');
                $data['customer_id'] = $request->get('customer_id');
                $data['contract_id'] = $request->get('contract_id');
                $data['email_address'] = $request->get('email_address');
                $data['date'] = $request->get('date');
                $data['current_price'] = $request->get('current_price');
                $data['price_offered'] = $request->get('price_offered');
                $data['status'] = $request->get('status');

//            $user = Auth::user();
//            Mail::send('BugRequest.BugRequestSendFile', $data, function ($message) use ($user) {
//                $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
//                $message->to('sarahmae.navales@1and1.com')->subject('1&1 Bug Request');
////                $message->cc($user->email, $user->name);
////                $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
//            });
            return view('retentioncase.RetentionCaseSendFile',$data);
                }
            Session::flash('flash_message', 'Retention Case updated!');
            return redirect('retentioncase/create');

        }
        
        public function sort_status($status) {
            $retentioncase = new RetentionCase();
            $breakdown = [
                    'name' => 'Retention Case',
                    'headers' => ['ID', 'Logged By', 'Customer ID', 'Contract ID', 'Date of Retention', 'Date of Submitted','Status'],
                    'headerStyle' => ['', '','', '', '', '', ''],
                    'data' => []
            ];
            
            if($status=='Successful'){
            $status = 'Successful';    
            $data['rows'] = $retentioncase->where('status', 'LIKE', "$status")->get();
            }
            if($status=='Unsuccessful'){
            $status = 'Unsuccessful';    
            $data['rows'] = $retentioncase->where('status', 'LIKE', "$status")->get();
            }
            if($status=='RA'){
            $status = 'RA';    
            $data['rows'] = $retentioncase->where('status', 'LIKE', "$status")->get();
            }
            if($status=='All'){ 
            $data['rows'] = $retentioncase->get();
            }
            
            $data['breakdown'] = $breakdown;
            $data['page_title'] = 'Retention Case';
            $data['perfurl'] = 'retentioncase';

            return view('retentioncase.RetentionCaseView', $data);
        }
        
        public function filter_date(Request $request){
            
        $date_from = $request->get('date_from');
        $from = date('Y-m-d', strtotime($date_from));
        $date_to = $request->get('date_to');
        $to = date('Y-m-d', strtotime($date_to));
        
        $retentioncase = new RetentionCase();
        $breakdown = [
                    'name' => 'Retention Case',
                    'headers' => ['ID', 'Logged By', 'Customer ID', 'Contract ID', 'Date of Retention', 'Date of Submitted','Status'],
                    'headerStyle' => ['', '','', '', '', '', ''],
                    'data' => []
            ];
        $data['all'] = $retentioncase->get();
        $data['rows'] = $retentioncase->where('created_at', '>=', $from)->where('updated_at', '<=', $to)->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Retention Case';
        $data['perfurl'] = 'retentioncase';

        return view('retentioncase.RetentionCaseView', $data);
    }
        
    }