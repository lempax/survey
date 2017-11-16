<?php

namespace App\Http\Controllers;

use App\SupervisoryCalls;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Mail;
use Session;
use App\Employee as Employee;
use App\Department as Department;

class SupervisoryCallsController extends Controller {

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
        if (Auth::user()->roles != "REGULAR") {
            $breakdown = [
                'name' => 'Supervisory Calls',
                'headers' => ['Case Date', 'Case Number', 'Agent', 'Team', 'Date Tracked'],
                'headerStyle' => ['', '', '', '', ''],
                'data' => []
            ];
        }
        $data['rows'] = DB::table('supervisorycalls')->get();
        $data['teams'] = DB::table('departments')->get();
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'Supervisory Calls';
        $data['perfurl'] = 'supervisorycalls';
        return view('supervisorycalls.supervisorycalls', $data);
    }

    public function add(Request $request) {

        $insertData = array(
            'case_number' => $request->get('case_number'),
            'requested_by' => Auth::user()->uid,
            'team' => $request->get('team'),
            'agent_name' => $request->get('agent_name'),
            'case_date' => date('Y-m-d', strtotime($request->get('case_date')))
        );

        SupervisoryCalls::create($insertData);

        $data['agent_name'] = Employee::where('uid', $request->get('agent_name'))->first();
        $data['team'] = Department::where('departmentid', $request->get('team'))->first();
        $data['requested_by'] = Employee::where('uid', Auth::user()->uid)->first();
        $data['case_number'] = $request->get('case_number');
        $data['case_date'] = $request->get('case_date');


        $user = Auth::user();
        Mail::send('supervisorycalls.supervisorycallsmail', $data, function ($message) use ($user) {
            $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
            $message->to($user->superior->email, $user->superior->name)->subject('1&1 Supervisory Calls');
            $message->cc($user->email, $user->name);
            $message->bcc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
        });

        return redirect('supervisorycalls/new');
    }

    public function view($id) {
        $data['page_title'] = 'Supervisory Calls';
        $data['perfurl'] = 'supervisorycalls';
        $data['rows'] = DB::table('supervisorycalls')->where('id', $id)->first();
        $data['teams'] = DB::table('departments')->get();
        return view('supervisorycalls.supervisorycallsview', $data);
    }

    public function get_agent($team) {
        $agents = \App\SupervisoryCalls::getFromEmployees($team);

        echo '<select class="form-control" name="agent_name" style="width: 350px;"  id="agent">';
        echo '<option value="">Select Agent</option>';
        foreach ($agents as $agent) {
            echo '<option value="' . $agent->uid . '">' . $agent->fname . ' ' . $agent->lname . '</option>';
        }
        echo '</select>';
    }

    public function update(Request $request) {

        $updateData = array(
            'case_number' => $request->get('case_number'),
            'requested_by' => $request->get('requested_by'),
            'team' => $request->get('team'),
            'agent_name' => $request->get('agent_name'),
            'case_date' => date('Y-m-d', strtotime($request->get('case_date')))
        );

        $calls = SupervisoryCalls::find($request->get('id'));
        $calls->update($updateData);

        Session::flash('flash_message', 'Update successful.');
        return redirect('supervisorycalls/view/' . $request->get('id'));
    }

}
