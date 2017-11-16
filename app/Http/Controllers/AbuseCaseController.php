<?php

namespace App\Http\Controllers;

use App\AbuseCase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use Auth;
use Session;
use App\Employee as Employee;

class AbuseCaseController extends Controller {

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
                'name' => 'Abuse Case',
                'headers' => ['ID', 'Employee Name', 'Case ID', 'Customer ID', 'Contract ID', 'Day Called', 'Date Called'],
                'headerStyle' => ['', '','', '', '', '', ''],
                'data' => []
            ];

            $abusecase = new AbuseCase();

            $data['rows'] = $abusecase->get();
            $data['breakdown'] = $breakdown;
            $data['page_title'] = '1&1 Abuse Case Tool';
            $data['page_desc'] = 'Displays all abuse cases.';
            $data['perfurl'] = 'abusecase';
            $data['form_title'] = "Your cases for " . date("F j, Y");
            return view('abusecase.AbuseCaseView', $data);
        }

        public function store(Request $request) {
            $this->validate($request, [
                    'employee_name' => 'required',
                    'case_id' => 'required|integer',
                    'customer_id' => 'required|integer',
                    'contract_id' => 'required||integer',
                    'day_called' => 'required',
                    'date_called' => 'required',
                    'comment' => 'required'
            ]);

            $insertData = array(
                'employee_name' => $request->get('employee_name'),
                'case_id' => $request->get('case_id'),
                'customer_id' => $request->get('customer_id'),
                'contract_id' => $request->get('contract_id'),
                'day_called' => $request->get('day_called'),
                'date_called' => date('Y-m-d', strtotime($request->get('date_called'))),
                'comment' => $request->get('comment')
            );
            
                if(isset($_POST['save'])){
                    AbuseCase::create($insertData);
                }
                if(isset($_POST['send'])){
                $data['employee_name'] = Employee::where('uid', $request->get('employee_name'))->first(); 
                $data['case_id'] = $request->get('case_id');
                $data['customer_id'] = $request->get('customer_id');
                $data['contract_id'] = $request->get('contract_id');
                $data['day_called'] = $request->get('day_called');
                $data['date_called'] = $request->get('date_called');
                $data['comment'] = $request->get('comment');

                $user = Auth::user();
                Mail::send('AbuseCase.AbuseCaseSendFile', $data, function ($message) use ($user) {
                    $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
                    $message->to('sarahmae.navales@1and1.com')->subject('1&1 Abuse Case Tool');
    //                $message->cc($user->email, $user->name);
    //                $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
                });
                }
            Session::flash('flash_message', 'Case Successfully Added!');
            return redirect('abusecase/create');   
    }
        
        public function edit($id, Request $request){

            $breakdown = [
                'name' => 'Abuse Case',
                'headers' => ['ID', 'Employee Name', 'Case ID', 'Customer ID', 'Contract ID', 'Day Called', 'Date Called'],
                'headerStyle' => ['', '','', '', '', '', ''],
                'data' => []
            ];

            $abusecase = new AbuseCase();

            $data['temp'] = $abusecase->where('id', $id)->first();
            $data['rows'] = $abusecase->get();
            $data['breakdown'] = $breakdown;
            $data['page_title'] = '1&1 Abuse Case Tool';
            $data['page_desc'] = 'Displays all Abuse Cases';
            $data['perfurl'] = 'abusecase';
            $data['form_title'] = "Your cases for " . date("F j, Y");
            return view('abusecase.AbuseCaseEdit', $data);

        }
        
        public function update(Request $request){
            
            $this->validate($request, [
                    'employee_name' => 'required',
                    'case_id' => 'required|integer',
                    'customer_id' => 'required|integer',
                    'contract_id' => 'required||integer',
                    'day_called' => 'required',
                    'date_called' => 'required',
                    'comment' => 'required'
            ]);

            $updateData = array(
                'employee_name' => $request->get('employee_name'),
                'case_id' => $request->get('case_id'),
                'customer_id' => $request->get('customer_id'),
                'contract_id' => $request->get('contract_id'),
                'day_called' => $request->get('day_called'),
                'date_called' => date('Y-m-d', strtotime($request->get('date_called'))),
                'comment' => $request->get('comment')
            );
                
                if(isset($_POST['save'])){
                $abusecase = AbuseCase::find($request->get('id'));
                $abusecase->update($updateData);
                }
                if(isset($_POST['send'])){
                $data['employee_name'] = Employee::where('uid', $request->get('employee_name'))->first(); 
                $data['case_id'] = $request->get('case_id');
                $data['customer_id'] = $request->get('customer_id');
                $data['contract_id'] = $request->get('contract_id');
                $data['day_called'] = $request->get('day_called');
                $data['date_called'] = $request->get('date_called');
                $data['comment'] = $request->get('comment');

////            $user = Auth::user();
////            Mail::send('AbuseCase.AbuseCaseSendFile', $data, function ($message) use ($user) {
////                $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
////                $message->to('sarahmae.navales@1and1.com')->subject('1&1 Abuse Case Tool');
//////                $message->cc($user->email, $user->name);
////                $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
//            });
            return view('abusecase.AbuseCaseSendFile',$data);
                }
            Session::flash('flash_message', 'Abuse case successfully updated!');
            return redirect('abusecase/create');

        }

    }
