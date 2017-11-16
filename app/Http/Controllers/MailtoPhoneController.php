<?php
namespace App\Http\Controllers;

use App\MailtoPhone;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use Session;
use Auth;
use App\Employee as Employee;  

class MailtoPhoneController extends Controller {
    
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

    public function newmailtophone() {

        $breakdown = [
            'name' => 'Case Processed',
            'headers' => ['ID', 'Date Created', 'Employee Name', 'Date of Case', 'Customer Reached', 'Status'],
            'headerStyle' => ['', '', '', '', '', ''],
            'data' => []
        ];

        $mailtophone = new MailtoPhone();

        $data['rows'] = $mailtophone->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = '1&1 US Medium-Change Tracking Tool';
        $data['page_desc'] = 'Display all medium-change CW03 cases logged by supervisors.';
        $data['perfurl'] = 'newmailtophone';
        $data['form_title'] = "Your cases for " . date("F j, Y");
        return view('MailtoPhone.MailtoPhoneView', $data);
    }

    public function storemailtophone(Request $request) {
        $this->validate($request, [
            'loggedby' => 'required',
            'employee_name' => 'required',
            'case_id' => 'required',
            'case_crr' => 'required',
            'date_ofcase' => 'required',
            'customer_reached' => 'required',
            'status' => 'required',
        ]);

        $case_id = $request->get('case_id');
        $case_crr = $request->get('case_crr');
        
        $insertData = array();
        for ($i = 0; $i < count($case_id); $i++) {
            $_case_id = $case_id[$i];
            $_case_crr = $case_crr[$i];
            
            $insertData[] = array(
                'case_id' => $_case_id,
                'case_crr' => $_case_crr
            );
            
        }
        $crr_json = json_encode($insertData);
        $new_array = array(
            'loggedby' => $request->get('loggedby'),
            'date_created' => $request->get('date_created'),
            'employee_name' => $request->get('employee_name'),
            'case_crr' => $crr_json,
            'date_ofcase' => date('Y-m-d', strtotime($request->get('date_ofcase'))),
            'customer_reached' => $request->get('customer_reached'),
            'reason' => $request->get('reason'),
            'status' => $request->get('status')
        );
            $data['loggedby'] = $request->get('loggedby');
            $data['employee_name'] = Employee::where('uid', $request->get('employee_name'))->first(); 
            $data['date_ofcase'] = $request->get('date_ofcase');
            $data['case_crr'] = $crr_json;
            $data['customer_reached'] = $request->get('customer_reached');
            $data['reason'] = $request->get('reason');
            $data['status'] = $request->get('status');
        
            $user = Auth::user();
            Mail::send('MailtoPhone.MailtoPhoneSendFile', $data, function ($message) use ($user) {
                $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
                $message->to($user->superior->email, $user->superior->name)->subject('1&1 Mail to Phone Tool');
                $message->cc($user->email, $user->name);
                $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
            });
            
            MailtoPhone::create($new_array);
            Session::flash('flash_message', 'Successfully Added!');
            return redirect('mailtophone/newmailtophone');
    }

    public function editmailtophone($id, Request $request) {

        $mailtophone = new MailtoPhone();
        $breakdown = [
            'name' => 'Case Processed',
            'headers' => ['ID', 'No. of Cases', 'Date Created', 'Employee Name', 'Date of Case', 'Customer Reached', 'Status'],
            'headerStyle' => ['','', '', '', '', '', ''],
            'data' => []
        ];

        $data['m2p'] = $mailtophone->where('id', $id)->first();
        $data['rows'] = $mailtophone->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = '1&1 US Medium-Change Tracking Tool';
        $data['page_desc'] = 'Display all medium-change CW03 cases logged by supervisors.';
        $data['perfurl'] = 'newmailtophone';
        $data['form_title'] = "Your cases for " . date("F j, Y");
        return view('MailtoPhone.MailtoPhoneEdit', $data);
    }

    public function updatemailtophone(Request $request) {

        $this->validate($request, [
            'loggedby' => 'required',
            'employee_name' => 'required',
            'case_id' => 'required',
            'case_crr' => 'required',
            'date_ofcase' => 'required',
            'customer_reached' => 'required',
            'status' => 'required',
        ]);
        
         $case_id = $request->get('case_id');
         $case_crr = $request->get('case_crr');

        $editData = array();
        for ($i = 0; $i < count($case_id); $i++) {
            $_case_id = $case_id[$i];
            $_case_crr = $case_crr[$i];
            
            $editData[] = array(
                'case_id' => $_case_id,
                'case_crr' => $_case_crr
            );
              
        }

        $crr_json = json_encode($editData);
        $update_array = array(
            'loggedby' => $request->get('loggedby'),
            'date_created' => $request->get('date_created'),
            'employee_name' => $request->get('employee_name'),
            'case_crr' => $crr_json,
            'date_ofcase' => date('Y-m-d', strtotime($request->get('date_ofcase'))),
            'customer_reached' => $request->get('customer_reached'),
            'reason' => $request->get('reason'),
            'status' => $request->get('status')
        );
       
            $data['loggedby'] = $request->get('loggedby');
            $data['employee_name'] = $request->get('employee_name');
            $data['case_crr'] = $crr_json;
            $data['date_ofcase'] = $request->get('date_ofcase');
            $data['customer_reached'] = $request->get('customer_reached');
            $data['reason'] = $request->get('reason');
            $data['status'] = $request->get('status');
        
      
//            $user = Auth::user();
//            Mail::send('MailtoPhone.MailtoPhoneSendFile', $data, function ($message) use ($user) {
//                $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
//                $message->to($user->superior->email, $user->superior->name)->subject('1&1 Mail to Phone Tool');
//                $message->cc($user->email, $user->name);
//                $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
//            });
            
            
            $mailtophone = MailtoPhone::find($request->get('id'));
            $mailtophone->update($update_array);
            Session::flash('flash_message', 'Case successfully updated!');
//            return redirect('mailtophone/newmailtophone');
             return view('MailtoPhone.MailtoPhoneSendFile',$data);
    }

}