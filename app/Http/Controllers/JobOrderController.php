<?php

namespace App\Http\Controllers;

use App\JobOrder;
use App\JobOrderComments;
use App\JobOrderHistory;
use App\JobOrderInProgress;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Session;
use Auth;
use DB;
use Mail;

class JobOrderController extends Controller {
    
    public function __construct() {
        $this->middleware('auth');
        if (Auth::check()) {
            $_team = Auth::user()->teams();
            if ($_team->count() == 1 && $_team->first()->departmentid = 21395000)
                $this->teams = \App\Department::where('name', 'like', 'U%')->get();
            else
                $this->teams = Auth::user()->teams();
                $this->exemptions = Auth::user()->settings()->type('filtered_list')->first() ?
                    json_decode(Auth::user()->settings()->type('filtered_list')->first()->entries) : [];
        }
    }

    public function create() {

        $breakdown = [
            'name' => 'Job Order Listings',
            'headers' => ['Title', 'Job Type', 'Submitted By', 'Priority', 'Created', 'Status'],
            'headerStyle' => ['', '', '', '', '', ''],
            'data' => []
        ];
        
        $joborder = new JobOrder();
        $data['breakdown'] = $breakdown;
        $data['rows'] = $joborder->get();
        $data['page_title'] = 'Create New Order';
        $data['perfurl'] = 'joborder';
        return view('joborder.JobOrderCreate', $data);
    }

    public function store(Request $request) {
        
        $this->validate($request, [
            'title' => 'required',
            'type' => 'required',
            'priority' => 'required',
            'description' => 'required',
        ]);
        
        $file = $request->file('attachments');
        $destinationPath = resource_path(). '/file_attachments/';
        $filename = $file->getClientOriginalName();
        $file->move($destinationPath, $filename);
        
            $insertData[] = array(
                'attachments' => $filename
            );
        
        
        $files = json_encode($insertData);
        $new_array = array(
            'attachments' => $files,
            'title' => $request->get('title'),
            'created_by' => $request->get('created_by'),
            'type' => $request->get('type'),
            'priority' => $request->get('priority'),
            'description' => $request->get('description'),
            'status' => $request->get('status'),
            'tid' => $request->get('tid')
        );
        
        JobOrder::create($new_array);  
        
        $temp_id = DB::table('job_order')->where('title', $request->get('title'))->first();
        $historyData = array(
            'id' => $temp_id->id,
            'details' => 'Job Order Created',
            'uid' => Auth::user()->uid
        );
        
        JobOrderHistory::create($historyData);  
        
        Session::flash('flash_message', 'Successfully Added!');

        $data['id'] = $request->get('id');
        $data['title'] = $request->get('title');
        $data['created_by'] = $request->get('created_by');
        $data['type'] = $request->get('type');
        $data['priority'] = $request->get('priority');
        $data['description'] = $request->get('description');
        $data['status'] = $request->get('status');
        $data['tid'] = $request->get('tid');
        $data['created_at'] = $request->get('created_at');
        $data['updated_at'] = $request->get('updated_at');
        $data['attachments'] = $request->get('attachments');
            
//            $user = Auth::user();
//            Mail::send('joborder.JobOrderSendFile', $data, function ($message) use ($user) {
//                $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
//                $message->to('sarahmae.navales@1and1.com')->subject('1&1 Job Order Tool');
//                $message->cc($user->email, $user->name);
//                $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
//            });
         //return view('joborder.JobOrderSendFile', $data);
        return redirect('joborder/create');
           
    }
    
    public function edit($id){
            
        $breakdown = [
            'name' => 'Job Order Listings',
            'headers' => ['Title', 'Job Type', 'Submitted By', 'Priority', 'Created', 'Status'],
            'headerStyle' => ['', '', '', '', '', ''],
            'data' => []
        ];
        
        $joborder = new JobOrder();
        $data['temp'] = $joborder->where('id', $id)->first();
        $data['rows'] = $joborder->get();
        
        $progress = new JobOrderInProgress();
        $data['prog'] = $progress->where('id', $id)->first();
        $data['progs'] = $progress->get();
        
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'View/Update Job Order';
        $data['perfurl'] = 'joborder';
        
        $history = new JobOrderHistory();
        $data['histories'] = $history->where('id', $id)->get();
        
        return view('joborder.JobOrderView', $data);
    }
    
    public function update(Request $request) {
        
        $files = $request->file('attachments');
        $file_count = count($files);
        $uploadcount= 0;
        foreach($files as $file){
            $rules = array('attachments' => 'required');
            $validator = Validator::make(array('attachments'=>$file), $rules);
            if($validator->passes()){
                $destinationPath = resource_path(). '/file_attachments/';
                $filename = $file->getClientOriginalName();
                $upload_sucess= $file->move($destinationPath, $filename);
                $uploadcount ++;
            }
        }
        if($uploadcount == $file_count){
            $updateData = array(
            'attachments' => $filename,
            'assigned_to' => $request->get('assigned_to'),   
            'status' => $request->get('status')       
            );

        $joborder= JobOrder::find($request->get('id'));
        $joborder->update($updateData);
        Session::flash('flash_message', 'Order successfully updated!');
        
        return redirect('joborder/create');
        }
    }
    
    public function getDownload($attachments){
        
        $file_path = resource_path('file_attachments/'.$attachments);
        $headers = array(
            'Content-Type: application/pdf',
        );
        
        return response()->download($file_path, $attachments, $headers);
    }
    
     public function comment(Request $request) {
        $id = $request->get('id');
        $comment = $request->get('comment');
        $private = $request->get('private');
        $status = $request->get('status');
        
        if($private!=1) $private=0;
        
        $insertData = array(
            'id' => $id,
            'uid' => Auth::user()->uid,
            'comment' => $comment,
            'private' => $private,
            'status' => $status
        );
        
       JobOrderComments::create($insertData);
       
        $historyData = array(
            'id' => $id,
            'details' => 'Comment Added',
            'uid' => Auth::user()->uid
        );
        
       JobOrderHistory::create($historyData);        
       return redirect('joborder/view/'.$request->get('id'));
    }
    
    public function status(Request $request){
        
         $this->validate($request, [
            'status' => 'required',
        ]);
        
        if($request->get('status')=="disapproved"){
            $updateData = array(
                'type' => $request->get('type'),
                'priority' => $request->get('priority'),
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'created_by' => $request->get('created_by'),
                'status' => $request->get('status'),
                'dreason' => $request->get('dreason'),
                'tid' => $request->get('tid')
            );
            
        $historyData = array(
            'id' => $request->get('id'),
            'details' => 'Status changed to Disapproved',
            'uid' => Auth::user()->uid
        );
            
        JobOrderHistory::create($historyData); 
            
        }elseif($request->get('status')=="approved"){
            $updateData = array(
                'type' => $request->get('type'),
                'priority' => $request->get('priority'),
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'created_by' => $request->get('created_by'),
                'status' => $request->get('status'),
                'tid' => $request->get('tid')
            );
            
        $historyData = array(
            'id' => $request->get('id'),
            'details' => 'Status changed to Approved',
            'uid' => Auth::user()->uid
        );
            
        JobOrderHistory::create($historyData); 
            
        }elseif($request->get('status')=="assigned"){
            $updateData = array(
                'type' => $request->get('type'),
                'priority' => $request->get('priority'),
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'created_by' => $request->get('created_by'),
                'status' => $request->get('status'),
                'tid' => $request->get('tid'),
                'assigned_to' => $request->get('assigned_to'),
            );
            
        $historyData = array(
            'id' => $request->get('id'),
            'details' => 'Status changed to Assigned',
            'uid' => Auth::user()->uid
        );
            
            JobOrderHistory::create($historyData); 
            
        $historyData = array(
            'id' => $request->get('id'),
            'details' => 'Assigned to',
            'uid' => Auth::user()->uid
        );
            
            JobOrderHistory::create($historyData); 
            
        }elseif($request->get('status')=="ongoing"){
            $updateData = array(
                'type' => $request->get('type'),
                'priority' => $request->get('priority'),
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'created_by' => $request->get('created_by'),
                'status' => $request->get('status'),
                'tid' => $request->get('tid'),
                'assigned_to' => $request->get('assigned_to'),
            );
            
            $ongoingData = array(
                'id' => $request->get('id'),
                'assignee' => $request->get('assigned_to'),
                'date_started' => $request->get('date_started'),
            );
            
            JobOrderInProgress::create($ongoingData); 
            
        $historyData = array(
            'id' => $request->get('id'),
            'details' => 'Status changed to In Progress',
            'uid' => Auth::user()->uid
        );
            
        JobOrderHistory::create($historyData); 
            
        }elseif($request->get('status')=="set_date"){
            $updateData = array(
                'type' => $request->get('type'),
                'priority' => $request->get('priority'),
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'created_by' => $request->get('created_by'),
                'status' => 'ongoing',
                'tid' => $request->get('tid'),
                'assigned_to' => $request->get('assigned_to'),
            );
            
            $ongoingData = array(
                'id' => $request->get('id'),
                'assignee' => $request->get('assigned_to'),
                'date_due' => date('Y-m-d', strtotime($request->get('deadline'))),
            );
            
            $ongoing = JobOrderInProgress::find($request->get('id'));
            $ongoing->update($ongoingData);
            
        $historyData = array(
            'id' => $request->get('id'),
            'details' => 'Due date set on',
            'uid' => Auth::user()->uid
        );
            
        JobOrderHistory::create($historyData);
            
        }elseif($request->get('status')=="closed"){
            $updateData = array(
                'type' => $request->get('type'),
                'priority' => $request->get('priority'),
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'created_by' => $request->get('created_by'),
                'status' => $request->get('status'),
                'tid' => $request->get('tid'),
                'assigned_to' => $request->get('assigned_to'),
            );
            
        $historyData = array(
            'id' => $request->get('id'),
            'details' => 'Status changed to Closed',
            'uid' => Auth::user()->uid
        );
            
        JobOrderHistory::create($historyData); 
            
        }else{
            $updateData = array(
                'type' => $request->get('type'),
                'priority' => $request->get('priority'),
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'created_by' => $request->get('created_by'),
                'status' => $request->get('status'),
                'dreason' => $request->get('dreason'),
                'tid' => $request->get('tid')
            );
        }
        
        $data['id'] = $request->get('id');
        $data['title'] = $request->get('title');
        $data['created_by'] = $request->get('created_by');
        $data['type'] = $request->get('type');
        $data['priority'] = $request->get('priority');
        $data['description'] = $request->get('description');
        $data['status'] = $request->get('status');
        $data['tid'] = $request->get('tid');
        $data['created_at'] = $request->get('created_at');
        $data['updated_at'] = $request->get('updated_at');
        $data['attachments'] = $request->get('attachments');
            
//            $user = Auth::user();
//            Mail::send('joborder.JobOrderSendFile', $data, function ($message) use ($user) {
//                $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
//                $message->to('sarahmae.navales@1and1.com')->subject('1&1 Job Order Tool');
//                $message->cc($user->email, $user->name);
//                $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
//            });
         //return view('joborder.JobOrderSendFile', $data);
        
        $order = JobOrder::find($request->get('id'));
        $order->update($updateData);
        
        return redirect('joborder/view/'.$request->get('id')); 
    }
    
    public function storeFiles(Request $request){
         $files = $request->file('attachments');
        
        foreach($files as $file){
            $destinationPath = resource_path(). '/file_attachments/';
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $editData = array();
              
                $editData[] = array(
                    'attachments' => $filename
                ); 
                    
            $try = json_encode($editData);
            $updateData = array(
                    'attachments' => $try,
                    'created_by' => $request->get('created_by'),
                    'status' => $request->get('status'),
                    'tid' => $request->get('tid'),
                    'assigned_to' => $request->get('assigned_to'),
            );
        }
        
        $historyData = array(
            'id' => $request->get('id'),
            'details' => 'New files attached',
            'uid' => Auth::user()->uid
        );
            
        JobOrderHistory::create($historyData);

        $upload = JobOrder::find($request->get('id'));
        $upload->update($updateData);
        return redirect('joborder/view/'.$request->get('id')); 
    }

}