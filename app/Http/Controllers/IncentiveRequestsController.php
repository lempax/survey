<?php

namespace App\Http\Controllers;
use App\IrisForms;
use App\IrisFormsRemarks;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Mail;
use Session;
use App\Employee as Employee;

class IncentiveRequestsController extends Controller {
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
    
    public function display() {

        $breakdown = [
            'name' => 'Incentive Requests',
            'headers' => ['Request ID', 'Requested By', 'Department', 'Date Submitted', 'Status'],
            'headerStyle' => ['', '', '', '', ''],
            'data' => []
        ];
        
        $incentiverequests = new IrisForms();
        $data['breakdown'] = $breakdown;
        $data['rows'] = $incentiverequests->get();
        $data['pending'] = $incentiverequests->where('status', 'pending')->get();
        $data['page_title'] = 'Online Incentive Request Form';
        $data['perfurl'] = 'incentives';
        return view('incentiverequests.incentiverequestscreate', $data);
    }
    
    public function add(Request $request) {
        
        $this->validate($request, 
            [   'reasons' => 'required' ]
        );

        $description = $request->get('description');
        $quantity = $request->get('quantity');
        $unit_cost = $request->get('unit_cost');
        
        $contentsData = array();
        for ($i = 0; $i < count($description); $i++) {
            $_description = $description[$i];
            $_quantity = $quantity[$i];
            $_unit_cost = $unit_cost[$i];
            $_total_amount = $_quantity * $_unit_cost;
            $ok=0;
            if($_description=='' || $_quantity==''){
                $ok=1;
                break;
            }
            $contentsData[] = array(
                'description' => $_description,
                'quantity' => $_quantity,
                'unit_cost' => $_unit_cost,
                'total_amount' => $_total_amount,
                'availability' => ''
            );   
        }
        $contents = json_encode($contentsData);
        $insertData = array(
            'id' => strtotime(date("F j, Y g:i")),
            'contents' => $contents,
            'reasons' => $request->get('reasons'),
            'department' => Auth::user()->department->name,
            'next_approval' => 1,
            'requested_by' => Auth::user()->uid,
            'quoted_by' => '',
            'date_quoted' => '',
            'dept_head' => '',
            'sga_admin' => '',
            'sga_manager' => '',
            'status' => 'pending'
        );
        
       if($ok == 1){
           Session::flash('error_message', 'Failed. Please fill in all necessary input fields.');
       }else{
            IrisForms::create($insertData);
            Session::flash('flash_message', 'Request sent!'); 
            
            $data['contents'] = $request->get('contents');
            $data['reasons'] = $request->get('reasons');

            $user = Auth::user();
            Mail::send('incentiverequests.incentiverequestsmail', $data, function ($message) use ($user) {
                $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
                $message->to('mary.magdadaro@1and1.com', "Mary Lunica Lucero")->subject('1&1 Incentive Request');
                $message->to('atleen.merelos@1and1.com', "Atleen Merelos")->subject('1&1 Incentive Request');
                $message->cc($user->email, $user->name);
                $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
            });
        }
    return redirect('incentives/new');
    }
    
    public function view($id){
        $incentiverequests = new IrisForms();
        $data['rows'] = $incentiverequests->where('id', $id)->first();
        $data['page_title'] = 'Incentive Request';
        $data['perfurl'] = 'incentives';
        return view('incentiverequests.incentiverequestsview', $data);
    }
    
    public function update(Request $request) {
        $description = $request->get('description');
        $quantity = $request->get('quantity');
        $unit_cost = $request->get('unit_cost');
        $availability = $request->get('availability');
        
        $contentsData = array();
        for ($i = 0; $i < count($description); $i++) {
            $_description = $description[$i];
            $_quantity = $quantity[$i];
            $_unit_cost = $unit_cost[$i];
            $_total_amount = $_quantity * $_unit_cost;
            $_availability = $availability[$i];
            
            $contentsData[] = array(
                'description' => $_description,
                'quantity' => $_quantity,
                'unit_cost' => $_unit_cost,
                'total_amount' => $_total_amount,
                'availability' => $_availability
            );
        }
        $contents = json_encode($contentsData);
        
        $insertData = array(
            'contents' => $contents,
            'reasons' => $request->get('reasons'),
            'department' => $request->get('department'),
            'next_approval' => $request->get('next_approval'),
            'requested_by' => $request->get('requested_by'),
            'quoted_by' => Auth::user()->uid,
            'date_quoted' => strtotime(date("F j, Y g:i")),
            'dept_head' => $request->get('dept_head'),
            'sga_admin' => $request->get('sga_admin'),
            'sga_manager' => $request->get('sga_manager'),
            'status' => 'pending'
        );
        
       $rqst = IrisForms::find($request->get('id'));
       $rqst->update($insertData);
       return redirect('incentives/view/'.$request->get('id'));
    }
    
    public function addremarks(Request $request) {
        $iris_id = $request->get('id');
        $visibility = $request->get('visibility');
        $remarks = $request->get('remarks');
        
        if($visibility!=1) $visibility=0;
        
        $insertData = array(
            'iris_id' => $iris_id,
            'changed_by' => Auth::user()->uid,
            'remarks' => $remarks,
            'visibility' => $visibility
        );
        
       IrisFormsRemarks::create($insertData);
       return redirect('incentives/view/'.$request->get('id'));
    }
    
    public function sort(Request $request) {

        $breakdown = [
             'name' => 'Incentive Requests',
            'headers' => ['Request ID', 'Requested By', 'Department', 'Date Submitted', 'Status'],
            'headerStyle' => ['', '', '', '', ''],
            'data' => []
        ];
        
        $sort = $request->get('category');
        
        $incentiverequests = new IrisForms();
        
        $data['breakdown'] = $breakdown;
        $data['pending'] = $incentiverequests->where('status', 'pending')->get();
        if($sort == 'Pending'){
            $data['rows'] = $incentiverequests->where('status', 'pending')->get();
        }else if($sort == 'Approved'){
            $data['rows'] = $incentiverequests->where('status', 'approved')->get();
        } else if($sort == 'Denied'){
            $data['rows'] = $incentiverequests->where('status', 'disapproved')->get();
        }else{
            $data['rows'] = $incentiverequests->get();
        }
        $data['page_title'] = 'Online Incentive Request Form';
        $data['perfurl'] = 'incentives';
        return view('incentiverequests.incentiverequeststatus', $data);
    }
    
    public function process(Request $request) {
        
        $incentiverequests = new IrisForms();
        $row = $incentiverequests->where('id', $request->get('id'))->first();
        
        if($request->get('status')=="Disapprove"){
            $insertData = array(
                'contents' => $request->get('contents'),
                'reasons' => $request->get('reasons'),
                'department' => $request->get('department'),
                'next_approval' => $request->get('next_approval'),
                'requested_by' => $request->get('requested_by'),
                'quoted_by' => $request->get('quoted_by'),
                'date_quoted' => $request->get('date_quoted'),
                'dept_head' => $request->get('dept_head'),
                'sga_admin' => $request->get('sga_admin'),
                'sga_manager' => $request->get('sga_manager'),
                'status' => 'disapproved'
            );
            
            $iris_id = $request->get('id');
            $visibility = 1;
            $remarks = $request->get('remarks');
            
            $remark = array(
                'iris_id' => $iris_id,
                'changed_by' => Auth::user()->uid,
                'remarks' => $remarks,
                'visibility' => $visibility
            );
            if($remarks!=""){
                IrisFormsRemarks::create($remark);
            }
            
        }else{
            switch($row->next_approval){
                case 1: $insertData = array(
                            'contents' => $request->get('contents'),
                            'reasons' => $request->get('reasons'),
                            'department' => $request->get('department'),
                            'next_approval' => 2,
                            'requested_by' => $request->get('requested_by'),
                            'quoted_by' => $request->get('quoted_by'),
                            'date_quoted' => $request->get('date_quoted'),
                            'dept_head' => '',
                            'sga_admin' => Auth::user()->uid,
                            'sga_manager' => '',
                            'status' => 'pending'
                        );
                        break;
                case 2: $insertData = array(
                            'contents' => $request->get('contents'),
                            'reasons' => $request->get('reasons'),
                            'department' => $request->get('department'),
                            'next_approval' => 3,
                            'requested_by' => $request->get('requested_by'),
                            'quoted_by' => $request->get('quoted_by'),
                            'date_quoted' => $request->get('date_quoted'),
                            'dept_head' => Auth::user()->uid,
                            'sga_admin' => $request->get('sga_admin'),
                            'sga_manager' => '',
                            'status' => 'pending'
                        );
                        break;
                case 3: $insertData = array(
                            'contents' => $request->get('contents'),
                            'reasons' => $request->get('reasons'),
                            'department' => $request->get('department'),
                            'next_approval' => 3,
                            'requested_by' => $request->get('requested_by'),
                            'quoted_by' => $request->get('quoted_by'),
                            'date_quoted' => $request->get('date_quoted'),
                            'dept_head' => $request->get('dept_head'),
                            'sga_admin' => $request->get('sga_admin'),
                            'sga_manager' => Auth::user()->uid,
                            'status' => 'approved'
                        );
                        break;  
            }
        }
        $rqst = IrisForms::find($request->get('id'));
        $rqst->update($insertData);
        return redirect('incentives/view/'.$request->get('id')); 
    }
}
