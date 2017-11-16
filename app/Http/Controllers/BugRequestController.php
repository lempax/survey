<?php

namespace App\Http\Controllers;

use App\BugRequest;
use App\BugComments;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use Auth;
use Session;
use App\Employee as Employee;

class BugRequestController extends Controller {

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

        public function newbugrequest() {

            $breakdown = [
                'name' => 'Bug Request',
                'headers' => ['Subject', 'Category', 'Logged By', 'Date Created', 'Status'],
                'headerStyle' => ['','', '', '', ''],
                'data' => []
            ];
            
            $bugrequest = new BugRequest();
            $data['rows'] = $bugrequest->get();
            $data['breakdown'] = $breakdown;
            $data['page_title'] = '1&1 Bug Request Tool';
            $data['page_desc'] = 'Displays all bug requests.';
            $data['perfurl'] = 'bugrequest';
            $data['form_title'] = "Your cases for " . date("F j, Y");
            return view('bugrequest.BugRequestView', $data);
        }

        public function store(Request $request) {
            $this->validate($request, [
                    'category' => 'required',
                    'subject' => 'required',
                    'customer_id' => 'required|integer',
                    'contract_id' => 'required||integer',
                    'tech_id' => 'required|integer',
                    'project_id' => 'required|integer',
                    'description' => 'required',
                    'solution' => 'required',
                    'behavior' => 'required',
                    'date_occurrence' => 'required',
                    'instruction' => 'required',
                    'os' => 'required',
                    'recipient' => 'required',
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
                'category' => $request->get('category'),
                'subject' => $request->get('subject'),
                'customer_id' => $request->get('customer_id'),
                'contract_id' => $request->get('contract_id'),
                'tech_id' => $request->get('tech_id'),
                'project_id' => $request->get('project_id'),
                'date_occurrence' => date('Y-m-d', strtotime($request->get('date_occurrence'))),
                'description' => $request->get('description'),
                'solution' => $request->get('solution'),
                'behavior' => $request->get('behavior'),
                'instruction' => $request->get('instruction'),
//                'files' => $request->get('files'),
                'browser1' => $request->get('browser1'),
                'browser2' => $request->get('browser2'),
                'os' => $request->get('os'),
                'recipient' => $request->get('recipient'),
                'status' => $request->get('status')
            );
            
            
                if(isset($_POST['save'])){
                    BugRequest::create($insertData);
                }
                if(isset($_POST['send'])){
                $data['loggedby'] = $request->get('loggedby');  
                $data['id'] = $request->get('id');
                $data['category'] = $request->get('category');
                $data['subject'] = $request->get('subject');
                $data['customer_id'] = $request->get('customer_id');
                $data['contract_id'] = $request->get('contract_id');
                $data['tech_id'] = $request->get('tech_id');
                $data['project_id'] = $request->get('project_id');
                $data['date_occurrence'] = $request->get('date_occurrence');
                $data['description'] = $request->get('description');
                $data['solution'] = $request->get('solution');
                $data['behavior'] = $request->get('behavior');
                $data['instruction'] = $request->get('instruction');
                $data['files'] = $request->get('files');
                $data['browser1'] = $request->get('browser1');
                $data['browser2'] = $request->get('browser2');
                $data['os'] = $request->get('os');
                $data['recipient'] = Employee::where('uid', $request->get('recipient'))->first(); 
                $data['status'] = $request->get('status');

//            $user = Auth::user();
//            Mail::send('BugRequest.BugRequestSendFile', $data, function ($message) use ($user) {
//                $message->from('no-reply@mis-ews.ph.schlund.net', '1&1 Bug Request Tool');
//                $message->to('sarahmae.navales@1and1.com')->subject('1&1 Bug Request');
////                $message->cc($user->email, $user->name);
////                $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
//            });
                return view('bugrequest.BugRequestSendFile',$data);
                }
                     
            Session::flash('flash_message', 'Successfully Added!');
            return redirect('bugrequest/create');
    }
        
        public function edit($id, Request $request){

            $breakdown = [
                'name' => 'Bug Request',
                'headers' => ['Subject', 'Category', 'Logged By', 'Date Created', 'Status'],
                'headerStyle' => ['','', '', '', ''],
                'data' => []
            ];

            $bugrequest = new BugRequest();
            $bugcomments = new BugComments();
            $data['trans_id']= $id;
            $data['bq'] = $bugrequest->where('id', $id)->first();
            $data['rows'] = $bugrequest->get();
            $data['all'] = $bugcomments->where('request_id', '=', $id)->get();
            $data['breakdown'] = $breakdown;
            $data['page_title'] = '1&1 Bug Request Tool';
            $data['page_desc'] = 'Displays all Bug Requests';
            $data['perfurl'] = 'bugrequest';
            $data['form_title'] = "Your cases for " . date("F j, Y");
            return view('bugrequest.BugRequestEdit', $data);

        }
        
        public function update(Request $request){
            
            $this->validate($request, [
                    'category' => 'required',
                    'subject' => 'required',
                    'customer_id' => 'required|integer',
                    'contract_id' => 'required||integer',
                    'tech_id' => 'required|integer',
                    'project_id' => 'required|integer',
                    'description' => 'required',
                    'solution' => 'required',
                    'behavior' => 'required',
                    'date_occurrence' => 'required',
                    'instruction' => 'required',
                    'os' => 'required',
                    'recipient' => 'required',
                    'status' => 'required'
            ]);

            $updateData = array(
                'loggedby' => $request->get('loggedby'),
                'category' => $request->get('category'),
                'subject' => $request->get('subject'),
                'customer_id' => $request->get('customer_id'),
                'contract_id' => $request->get('contract_id'),
                'tech_id' => $request->get('tech_id'),
                'project_id' => $request->get('project_id'),
                'date_occurrence' => date('Y-m-d', strtotime($request->get('date_occurrence'))),
                'description' => $request->get('description'),
                'solution' => $request->get('solution'),
                'behavior' => $request->get('behavior'),
                'instruction' => $request->get('instruction'),
//                'files' => $request->get('files'),
                'browser1' => $request->get('browser1'),
                'browser2' => $request->get('browser2'),
                'os' => $request->get('os'),
                'recipient' => $request->get('recipient'),
                'status' => $request->get('status')    
            );
                
                if(isset($_POST['save'])){
                $bugrequest = BugRequest::find($request->get('id'));
                $bugrequest->update($updateData);
                }
                if(isset($_POST['send'])){     
                $data['id'] = $request->get('id'); 
                $data['loggedby'] = $request->get('loggedby');
                $data['category'] = $request->get('category');
                $data['subject'] = $request->get('subject');
                $data['customer_id'] = $request->get('customer_id');
                $data['contract_id'] = $request->get('contract_id');
                $data['tech_id'] = $request->get('tech_id');
                $data['project_id'] = $request->get('project_id');
                $data['date_occurrence'] = $request->get('date_occurrence');
                $data['description'] = $request->get('description');
                $data['solution'] = $request->get('solution');
                $data['behavior'] = $request->get('behavior');
                $data['instruction'] = $request->get('instruction');
                $data['files'] = $request->get('files');
                $data['browser1'] = $request->get('browser1');
                $data['browser2'] = $request->get('browser2');
                $data['os'] = $request->get('os');
                $data['recipient'] = Employee::where('uid', $request->get('recipient'))->first(); 
                $data['status'] = $request->get('status'); 

//            $user = Auth::user();
//            Mail::send('BugRequest.BugRequestSendFile', $data, function ($message) use ($user) {
//                $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
//                $message->to('sarahmae.navales@1and1.com')->subject('1&1 Bug Request');
////                $message->cc($user->email, $user->name);
////                $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
//            });
            return view('bugrequest.BugRequestSendFile',$data);
                }
            Session::flash('flash_message', 'Bug Request updated!');
            return redirect('bugrequest/create');

        }
        
        public function sort_category($category) {
           
            $bugrequest = new BugRequest();
            $breakdown = [
                'name' => 'Bug Request',
                'headers' => ['Subject', 'Category', 'Logged By', 'Date Created', 'Status'],
                'headerStyle' => ['','', '', '', ''],
                'data' => []
            ];
            
            if($category=='MyWebsite'){
            $category = 'MyWebsite';    
            $data['rows'] = $bugrequest->where('category', 'LIKE', "%$category%")->get();
            }
            if($category=='Webhosting'){
            $category = 'Webhosting';    
            $data['rows'] = $bugrequest->where('category', 'LIKE', "%$category%")->get();
            }
            if($category=='E-Business'){
            $category = 'E-Business';    
            $data['rows'] = $bugrequest->where('category', 'LIKE', "%$category%")->get();
            }
            if($category=='Contract Management'){
            $category = 'Contract Management';    
            $data['rows'] = $bugrequest->where('category', 'LIKE', "%$category%")->get();
            }
            if($category=='Domain'){
            $category = 'Domain';    
            $data['rows'] = $bugrequest->where('category', 'LIKE', "%$category%")->get();
            }
            if($category=='Control Panel'){
            $category = 'Control Panel';    
            $data['rows'] = $bugrequest->where('category', 'LIKE', "%$category%")->get();
            }
            if($category=='Mail'){
            $category = 'Mail';    
            $data['rows'] = $bugrequest->where('category', 'LIKE', "%$category%")->get();
            }
            if($category=='All'){ 
            $data['rows'] = $bugrequest->get();
            }
            
            $data['breakdown'] = $breakdown;
            $data['page_title'] = 'Bug Request';
            $data['perfurl'] = 'bugrequest';

            return view('bugrequest.BugRequestView', $data);
        }
    
        public function sort_status($status) {
            $bugrequest = new BugRequest();
            $breakdown = [
                'name' => 'Bug Request',
                'headers' => ['Subject', 'Category', 'Logged By', 'Date Created', 'Status'],
                'headerStyle' => ['','', '', '', ''],
                'data' => []
            ];
            
            if($status=='Open'){
            $status = 'Open';    
            $data['rows'] = $bugrequest->where('status', 'LIKE', "%$status%")->get();
            }
            if($status=='Resolved'){
            $status = 'Resolved';    
            $data['rows'] = $bugrequest->where('status', 'LIKE', "%$status%")->get();
            }
            if($status=='Created'){
            $status = 'Created';    
            $data['rows'] = $bugrequest->where('status', 'LIKE', "%$status%")->get();
            }
            if($status=='All'){ 
            $data['rows'] = $bugrequest->get();
            }
            
            $data['breakdown'] = $breakdown;
            $data['page_title'] = 'Bug Request';
            $data['perfurl'] = 'bugrequest';

            return view('bugrequest.BugRequestView', $data);
        }
        
        public function filter_date(Request $request){
            
        $date_from = $request->get('date_from');
        $from = date('Y-m-d', strtotime($date_from));
        $date_to = $request->get('date_to');
        $to = date('Y-m-d', strtotime($date_to));
        
        $bugrequest = new BugRequest();
        $breakdown = [
                'name' => 'Bug Request',
                'headers' => ['Subject', 'Category', 'Logged By', 'Date Created', 'Status'],
                'headerStyle' => ['','', '', '', ''],
                'data' => []
        ];
        $data['all'] = $bugrequest->get();
        $data['rows'] = $bugrequest->where('created_at', '>=', $from)->where('updated_at', '<=', $to)->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Bug Request';
        $data['perfurl'] = 'bugrequest';

        return view('bugrequest.BugRequestView', $data);
    }
        
        public function comment($id, Request $request){
            
            if(isset($_POST['add'])){
                $comments = array(
                    'message' => $request->get('commentmsg'),
                    'username' => Auth::user()->uid,
                    'request_id' =>$request->get('request_id')
                );
                
                BugComments::create($comments);
                

//            $user = Auth::user();
//            Mail::send('BugRequest.BugCommentsSendFile', $data, function ($message) use ($user) {
//                $message->from('no-reply@mis-ews.ph.schlund.net', '1&1 Bug Request Tool');
//                $message->to('sarahmae.navales@1and1.com')->subject('1&1 Bug Request');
////                $message->cc($user->email, $user->name);
////                $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
//            });
                //return view('bugrequest.BugCommentsSendFile',$data);
            }
            
             $breakdown = [
                'name' => 'Bug Request',
                'headers' => ['Subject', 'Category', 'Logged By', 'Date Created', 'Status'],
                'headerStyle' => ['','', '', '', ''],
                'data' => []
            ];

            $bugrequest = new BugRequest();
            $data['trans_id']= $id;
            $data['bq'] = $bugrequest->where('id', $id)->first();
            $data['rows'] = $bugrequest->get();
            $data['breakdown'] = $breakdown;
            $data['page_title'] = '1&1 Bug Request Tool';
            $data['page_desc'] = 'Displays all bug requests.';
            $data['perfurl'] = 'bugrequest';
            $data['form_title'] = "Your cases for " . date("F j, Y");
            
            $bugcomments = new BugComments();
            $data['all'] = $bugcomments->where('request_id', '=', $id)->get();
            
            return view('bugrequest.BugRequestEdit', $data);
            //return redirect('bugrequest/edit/'.$id);
        }  
    }