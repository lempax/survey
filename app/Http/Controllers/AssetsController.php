<?php

namespace App\Http\Controllers;
use App\AssetsIssuance;
use App\AssetsIssuanceItems;
use App\AssetsItems;
use App\AssetsRemarks;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Employee as Employee;
use Auth;
use DB;
use Mail;
use Session;

class AssetsController extends Controller {
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
            'name' => 'Assets Tracking Tool',
            'assets_headers' => ['Category', 'Item Name', 'Details', 'Qty', 'Supplier', 'Delivery', 'Warranty'],
            'headerStyle' => ['', '', '', '', '', '', ''],
            'issuance_headers' => ['Issued Id', 'Issued By', 'Issued To', 'Department', 'Date Issued', 'Status'],
            'headerStyle2' => ['', '', '', '', '', '', '', ''],
            'data' => []
        ];
        $data['assets'] = DB::table('assets_items')->get();
        $data['issuance'] = DB::table('assets_issuance')->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Assets Tracking Tool';
        $data['perfurl'] = 'assets';
        return view('assets.assets', $data);
    }
    
    public function getemployee($department){
        $employee = \App\AssetsIssuance::getFromEmployees($department);     

        echo '<select class="form-control" name="issued_to" style="width: 300px;"  id="employee">';
        echo '<option value="">Select an Employee</option>';
        foreach ($employee as $emp) {
            echo '<option value="'. $emp->uid .'">'. $emp->fname .' '. $emp->lname .'</option>';
        }
        echo '</select>';
      
    }
    
    public function addasset(Request $request) {
        $insertData = array(
            'category' => $request->get('category'),
            'name' =>$request->get('name'),
            'serial' => $request->get('serial'),
            'quantity' =>$request->get('quantity'),
            'supplier' => $request->get('supplier'),
            'date_delivered' => date('Y-m-d', strtotime( $request->get('date_delivered'))),
            'warranty_date' => date('Y-m-d', strtotime( $request->get('warranty_date'))),
            'logged_by' => Auth::user()->uid
        );
        AssetsItems::create($insertData);
        return redirect('assets/new');
    }
    
    public function view($id){
        $breakdown = [
            'name' => 'Assets Tracking Tool',
            'headers' => ['Category', 'Item', 'Details', 'Qty'],
            'headerStyle' => ['', '', '', ''],
            'data' => []
        ];
        $data['rows'] = DB::table('assets_issuance')->where('issued_id', $id)->first();
        $data['items'] = DB::table('assets_issuance_item')->where('issued_id', $id)->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Assets Tracking Tool';
        $data['perfurl'] = 'assets';
        return view('assets.assetsview', $data);
    }
    
    public function action(Request $request){
        $action = $request->get('action');
        
        switch($action){
            case 'add_remark':
                $addRemark = array (
                    'remarks_id' => $request->get('issued_id'),
                    'remarks_by' => Auth::user()->uid,
                    'remarks' => $request->get('remark')
                );
                AssetsRemarks::create($addRemark);
                break;
            case 'accepted':
                if(crypt($request->get('password'), Auth::user()->password) == Auth::user()->password){
                    //............update data..............
                    $items = DB::table('assets_issuance')->where('issued_id', $request->get('issued_id'))->first();
                    $approveData = array (
                        'issued_by' => $items->issued_by,
                        'issued_to' => $items->issued_to,
                        'department' => $items->department,
                        'purpose' => $items->purpose,
                        'date_issued' => $items->date_issued,
                        'prepared_by' => $items->prepared_by,
                        'approved_by' => Auth::user()->uid,
                        'status' => 'approved'
                    );
                    DB::table('assets_issuance')->where('issued_id', $request->get('issued_id'))
                        ->update($approveData);
                    
                    //.............subtract from database..........
                    $item_id = $request->get('id');
                    $quantity = $request->get('quantity');

                    for ($i = 0; $i < count($item_id); $i++) {
                        $_item_id = $item_id[$i];
                        $_quantity = $quantity[$i];

                        $issue = new AssetsIssuanceItems();
                        $issue->issueItem($_item_id, $_quantity);
                    } 
                    
                    //................send mail..................
                    $data['issued_id'] = $request->get('issued_id');
                    $emp = DB::table('employees')->where('uid', $items->issued_to)->first();
                    $data['name'] = $emp->fname;
                    Mail::send('assets.assetsmail', $data, function ($message) use ($user) {
                        $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
                        $message->to($emp->email, $emp->fname)->subject('1&1 Assets Tracking Tool');
                        $message->cc($user->email, $user->name);
                        $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
                    });
                }else{
                    Session::flash('error_message', 'Incorrect password. Try again.');
                }
                break;
            case 'approved':
                //............update data..............
                $items = DB::table('assets_issuance')->where('issued_id', $request->get('issued_id'))->first();
                $approveData = array (
                    'issued_by' => $items->issued_by,
                    'issued_to' => $items->issued_to,
                    'department' => $items->department,
                    'purpose' => $items->purpose,
                    'date_issued' => $items->date_issued,
                    'prepared_by' => $items->prepared_by,
                    'approved_by' => Auth::user()->uid,
                    'status' => 'approved'
                );
                DB::table('assets_issuance')->where('issued_id', $request->get('issued_id'))
                    ->update($approveData);

                //.............subtract from database..........
                $item_id = $request->get('id');
                $quantity = $request->get('quantity');

                for ($i = 0; $i < count($item_id); $i++) {
                    $_item_id = $item_id[$i];
                    $_quantity = $quantity[$i];

                    $issue = new AssetsIssuanceItems();
                    $issue->issueItem($_item_id, $_quantity);
                } 

                //................send mail..................
                $data['issued_id'] = $request->get('issued_id');
                $emp = DB::table('employees')->where('uid', $items->issued_to)->first();
                $data['name'] = $emp->fname;
                Mail::send('assets.assetsmail', $data, function ($message) use ($user) {
                    $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
                    $message->to($emp->email, $emp->fname)->subject('1&1 Assets Tracking Tool');
                    $message->cc($user->email, $user->name);
                    $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
                });
                break;
            case 'disapproved':
                $items = DB::table('assets_issuance')->where('issued_id', $request->get('issued_id'))->first();
                $disapproveData = array (
                    'issued_by' => $items->issued_by,
                    'issued_to' => $items->issued_to,
                    'department' => $items->department,
                    'purpose' => $items->purpose,
                    'date_issued' => $items->date_issued,
                    'prepared_by' => $items->prepared_by,
                    'approved_by' => Auth::user()->uid,
                    'status' => 'disapproved'
                );
                DB::table('assets_issuance')->where('issued_id', $request->get('issued_id'))
                        ->update($disapproveData);
                break;
        }
       
        return redirect('assets/view/'.$request->get('issued_id'));
    }
    
    public function selectitem(){
        $data['page_title'] =  'Select Item/s';
        $data['items'] = DB::table('assets_items')->get();
        return view('assets.selectitems', $data);
    }
    
    public function addissuance(Request $request) {
        $insertData = array(
            'issued_id' => $request->get('issued_id'),
            'issued_by' => Auth::user()->uid,
            'issued_to' => $request->get('issued_to'),
            'department' =>$request->get('department'),
            'purpose' => $request->get('purpose'),
            'date_issued' => date('Y-m-d'),
            'prepared_by' => Auth::user()->uid,
            'approved_by' => '',
            'status' => 'pending',
            'remarks' => ''
        );
        
        $item_id = $request->get('item_id');
        $quantity = $request->get('quantity');
        $serial = $request->get('serial');
        
        $issuedItem = array();
        for ($i = 0; $i < count($item_id); $i++) {
            $_item_id = $item_id[$i];
            $_quantity = $quantity[$i];
            $_serial = $serial[$i];
            $issued_id =  $request->get('issued_id');
            
            $issuedItem = array(
                'issued_id' =>$issued_id,
                'item_id' => $_item_id,
                'quantity' => $_quantity,
                'serial' => $_serial
            );
            AssetsIssuanceItems::create($issuedItem);
        }
        AssetsIssuance::create($insertData);
        return redirect('assets/new');
    }
}