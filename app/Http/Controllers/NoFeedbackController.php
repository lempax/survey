<?php

namespace App\Http\Controllers;

use App\NoFeedback;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Mail;
use Session;
use App\Employee as Employee;

class NoFeedbackController extends Controller {
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
            'name' => 'No Feedback Cases',
            'headers' => ['Team', 'Agent', 'No. of Calls', 'No. of Emails', 'Date of Case'],
            'headerStyle' => ['', '', '', '', ''],
            'data' => []
        ];
        
        $nofeedback = new NoFeedback();

        $data['rows'] = $nofeedback->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = '1&1 No Feedback Cases';
        $data['perfurl'] = 'nofeedback';
        $data['form_title'] = "Your cases for " . date("F j, Y");
        return view('nofeedback.nofeedbackview', $data);
    }

    public function store(Request $request) {
        
        $this->validate($request, 
            [   'team' => 'required',
                'reason' => 'required',
                'calls' => 'required|integer',
                'emails' => 'required|integer',
                'actionplan' => 'required',
                'casedate' => 'required'
            ]
        );

        
        $insertData = array(
            'team' => $request->get('team'),
            'agent' => $request->get('agent'),
            'reason' => $request->get('reason'),
            'calls' => $request->get('calls'),
            'emails' => $request->get('emails'),
            'actionplan' => $request->get('actionplan'),
            'casedate' => date('Y-m-d', strtotime( $request->get('casedate')))

        );
            
            $data['team'] = $request->get('team');
            $data['agent'] = Employee::where('uid', $request->get('agent'))->first();
            $data['reason'] = $request->get('reason');
            $data['calls'] = $request->get('calls');
            $data['emails'] = $request->get('emails');
            $data['actionplan'] = $request->get('actionplan');
            $data['casedate'] = $request->get('casedate');
            
        NoFeedback::create($insertData);
        Session::flash('flash_message', 'Case added!');
         
        $user = Auth::user();
        Mail::send('nofeedback.nofeedbacksendfile', $data, function ($message) use ($user) {
            $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
            $message->to($user->superior->email, $user->superior->name)->subject('1&1 No Feedback Tool');
            $message->cc($user->email, $user->name);
            $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
        });
            
        return redirect('nofeedback/create');
    }
    
   
    public function retrieve($id){
        $nofeedback = new NoFeedback();
        $breakdown = [
            'name' => 'No Feedback Cases',
            'headers' => ['Team', 'Agent', 'No. of Calls', 'No. of Emails', 'Date of Case'],
            'headerStyle' => ['', '', '', '', ''],
            'data' => []
        ];

        $data['temp'] = $nofeedback->where('id', $id)->first();
        $data['rows'] = $nofeedback->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = '1&1 No Feedback Cases';
        $data['perfurl'] = 'nofeedback';
        $data['form_title'] = "Your cases for " . date("F j, Y");

        return view('nofeedback.nofeedbackedit', $data);
    }
    
}
