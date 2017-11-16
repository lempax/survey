<?php

namespace App\Http\Controllers;

use App\MailSAS;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use Auth;
use Session;
use App\Employee as Employee;

class MailSASController extends Controller {

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
            'name' => '1&1 Mail.com SAS Cases',
            'headers' => ['Employee Name', 'Customer ID', 'Case ID', 'Contract ID', 'Product Cycle', 'Date Upsells', 'Order Date', 'Notes', 'Date Created'],
            'headerStyle' => ['','', '', '', '', '', '', '', ''],
            'data' => [] 
        ];
           
        $msas = new MailSAS();
       
        $data['rows'] = $msas->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = '1&1 Mail.com SAS Cases';
        $data['page_desc'] = 'Displays all cases created by the Mail.com team.';
        $data['perfurl'] = 'msas';
        $data['form_title'] = "[Date: " . date("F j, Y"). "]";
        return view('mailsas.MailSASView', $data);
    }

    public function store(Request $request) {
         $this->validate($request, [
            //'emp_name' => 'required',
            'custID' => 'required',
            'caseID' => 'required',
            'contractID' => 'required',
            'product_cycle' => 'required',
            'date_upsells' => 'required',
            'notes' => 'required',
            'order_date' => 'required'
        ]);
        
        $insertData = array(
            'emp_name' => $request->get('emp_name'),
            'custID' => $request->get('custID'),
            'caseID' => $request->get('caseID'),
            'contractID' => $request->get('contractID'),
            'product_cycle' => $request->get('product_cycle'),
            'date_upsells' => date('Y-m-d', strtotime($request->get('date_upsells'))),
            'order_date' => date('Y-m-d', strtotime($request->get('order_date'))),
            'notes' => $request->get('notes')
        );
        
        $data['emp_name'] = Employee::where('uid', $request->get('emp_name'))->first();
        $data['custID'] = $request->get('custID');
        $data['caseID'] = $request->get('caseID');
        $data['contractID'] = $request->get('contractID');
        $data['product_cycle'] = $request->get('product_cycle');
        $data['date_upsells'] = $request->get('date_upsells');
        $data['order_date'] = $request->get('order_date');
        $data['notes'] = $request->get('notes');
       
        $user = Auth::user();
         Mail::send('mailsas.MailSASSendMail', $data, function ($message) use ($user) {
            $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
           $message->to($user->superior->email, $user->superior->name)->subject('1&1 Mail.com SAS Tool');
           $message->cc($user->email, $user->name);
           $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
        });

        MailSAS::create($insertData);
        Session::flash('flash_message', 'Case successfully added!');
        return redirect('msas/newcase');
    }
    public function edit($id, Request $request){
        
        $breakdown = [
            'name' => '1&1 Mail.com SAS',
            'headers' => ['Employee Name', 'Customer ID', 'Case ID', 'Contract ID', 'Product Cycle', 'Date Upsells', 'Order Date', 'Notes', 'Date Created'],
            'headerStyle' => ['','', '', '', '', '', '', '', ''],
            'data' => []
        ];
           
        $msas = new MailSAS();
        
        $data['data1'] = $msas->where('id', $id)->first();
        $data['rows'] = $msas->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = '1&1 Mail.com SAS Cases';
        $data['page_desc'] = 'Displays all cases created by the Mail.com team.';
        $data['perfurl'] = 'msas';
        $data['form_title'] = "Your cases for " . date("F j, Y");
        return view('mailsas.MailSASEdit', $data);
    
    }
    public function filter_date(Request $request){
        $date_from = $request->get('date_from');
        $from = date('Y-m-d', strtotime($date_from));
        $date_to = $request->get('date_to');
        $to = date('Y-m-d', strtotime($date_to));
        
        $msas = new MailSAS();
        $breakdown = [
            'name' => '1&1 Mail.com SAS Cases',
            'headers' => ['Employee Name', 'Customer ID', 'Case ID', 'Contract ID', 'Product Cycle', 'Date Upsells', 'Order Date', 'Notes', 'Date Created'],
            'headerStyle' => ['','', '', '', '', '', '', '', ''],
            'data' => []
        ];
        
        $data['all'] = $msas->get();
        $data['rows'] = $msas->where('created_at', '>=', $from)->where('updated_at', '<=', $to)->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = '1&1 Mail.com SAS';
        $data['perfurl'] = 'msas';

        return view('mailsas.MailSASView', $data);
    }
    public function sort(){
        $mailsas = new MailSAS();
        $breakdown = [
            'name' => '1&1 Mail.com SAS',
            'headers' => ['Employee Name', 'Customer ID', 'Case ID', 'Contract ID', 'Product Cycle', 'Date Upsells', 'Order Date', 'Notes', 'Date Created'],
            'headerStyle' => ['','', '', '', '', '', '', '', ''],
            'data' => []
        ];
        
        if(isset($_POST['all'])){
            $data['rows'] = $mailsas->get();
        }
        if(isset($_POST['today'])){
            $today = date("Y-m-d");
            $data['rows'] = $mailsas->where('created_at', 'LIKE', "$today%")->get();
        }
        if(isset($_POST['monthly'])){
           $month = date("Y-m");
           $data['rows'] = $mailsas->where('created_at', 'LIKE', "$month%")->get();
        }
        if(isset($_POST['weekly'])){
           $today = date("Y-m-d");
           $week = date('W', strtotime($today));
           $data['rows'] = $mailsas->where('week', 'LIKE', "$week")->get();
        }
        
        $data['breakdown'] = $breakdown;
        $data['page_title'] = '1&1 Mail.com SAS Cases';
        $data['perfurl'] = 'msas';
        return view('mailsas.MailSASView', $data);
    }
}                                                                                                       