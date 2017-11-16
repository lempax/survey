<?php

namespace App\Http\Controllers;

use App\IssuanceItem;
use App\IssuedItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use DB;
use Auth;
use Session;
use App\Employee as Employee;
use App\Department as Department;

class ItemIssuanceController extends Controller {

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
    
    public function create() {
        $breakdown = [
            'name' => 'Issuance Processed',
            'headers' => ['Issuance ID', 'Issued By', 'Issued To', 'Department', 'Date Issued'],
            'headerStyle' => ['', '', '', '', ''],
            'data' => []
        ];
        
        $issuanceitem = new IssuanceItem();
        $data['rows'] = $issuanceitem->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Item Issuance Tool';
        $data['page_desc'] = '';
        $data['perfurl'] = 'itemissuance';
        $data['form_title'] = "Your cases for " . date("F j, Y");
        return view('issuanceitem.IssuanceItemView', $data);
    }
    
    public function store(Request $request) {
        $this->validate($request, [
                'issued_to' => 'required',
                'department' => 'required',
                'purpose' => 'required',
                'attached_mris' => 'required',
                'attached_iris' => 'required'
        ]);
        
        $insertData = array(
            'issued_id' => $request->get('issued_id'),
            'issued_by' => Auth::user()->uid,
            'issued_to' => $request->get('issued_to'),
            'department' =>$request->get('department'),
            'purpose' => $request->get('purpose'),
            'attached_mris' => $request->get('attached_mris'),
            'attached_iris' => $request->get('attached_iris')
        );
        
        //item store
        $item_id = $request->get('item_id');
        $quantity = $request->get('quantity');
        $serial = $request->get('serial');
        $price = $request->get('price');
        
        $issueditem = array();
        for ($i = 0; $i < count($item_id); $i++) {
            $_item_id = $item_id[$i];
            $_quantity = $quantity[$i];
            $_serial = $serial[$i];
            $_price = $price[$i];
            
            $issueditem = array(
                'issued_id' => $request->get('issued_id'),
                'item_id' => $_item_id,
                'quantity' => $_quantity,
                'serial' => $_serial,
                'price' => $_price
            );
            IssuedItem::create($issueditem);
        }
        $data['issued_id'] = $request->get('issued_id');
        $data['department'] = $request->get('department');
        $data['issued_by'] = $request->get('issued_by');
        $data['issued_to'] = $request->get('issued_to');
        $data['purpose'] = $request->get('purpose');
        $data['attached_mris'] = $request->get('attached_mris');
        $data['attached_iris'] = $request->get('attached_iris');
        $data['quantity'] = $request->get('quantity');
        $data['name'] = $request->get('name');
        $data['serial'] = $request->get('serial');
        $data['price'] = $request->get('price');
        
        $user = Auth::user();
//        Mail::send('saslowperformers.SASLowPerformersSendMail', $data, function ($message) use ($user) {
//          $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
//          $message->to($user->superior->email, $user->superior->name)->subject('1&1 SAS Low Performers Tool');
//          $message->cc($user->email, $user->name);
//          $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
//        });  
//        
        IssuanceItem::create($insertData);     
        //return view('issuanceitem.IssuanceItemSendFile', $data);
        Session::flash('flash_message', 'Case successfully added!');
        return redirect('itemissuance/create');
    }
    
    public function view($id, Request $request){
        $breakdown = [
            'name' => 'Item Issuance Tool',
            'headers' => ['Quantity', 'Item Name', 'Serial No.', 'Price'],
            'headerStyle' => ['', '', '', ''],
            'data' => []
        ];
        $data['rows'] = DB::table('issuanceitem')->where('issued_id', $id)->first();
        $data['items'] = DB::table('issueditem')->where('issued_id', $id)->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Item Issuance Tool';
        $data['page_desc'] = '';
        $data['perfurl'] = 'itemissuance';
        $data['form_title'] = "Your cases for " . date("F j, Y");
        return view('issuanceitem.IssuanceItemDisplay', $data);
    }
    public function getemployee($department){
        $employee = \App\IssuanceItem::getFromEmployees($department);     

        echo '<select class="form-control" name="issued_to" style="width: 300px;"  id="employee">';
        echo '<option value="">Select an Employee</option>';
        foreach ($employee as $emp) {
            echo '<option value="'. $emp->uid .'">'. $emp->fname .' '. $emp->lname .'</option>';
        }
        echo '</select>';
      
    }   
    public function items_select() {
        $data['page_title'] =  'Select Item(s)';
        $data['items'] = DB::table('items')->get();
        return view('issuanceitem.IssuanceItemSelect', $data);
    }
    
} 