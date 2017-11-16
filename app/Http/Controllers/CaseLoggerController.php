<?php

namespace App\Http\Controllers;

use App\LoggedCases;
use App\Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use Auth;

class CaseLoggerController extends Controller {

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

    public function loadform() {
        $breakdown = [
            'name' => '',
            'headers' => ['Logged By', 'Date Created', 'Calls', 'Emails', 'Chats', 'Reached M2P', 'Forwarded M2P', 'Total Cases Processed'],
            'headerStyle' => ['', '', '', '', '', '', '', ''],
            'data' => []
        ];

        foreach (Auth::user()->logged_cases AS $case) {
            $_content = json_decode($case->content, true);
            $breakdown['data'][] = [
                $case->user->name, date("F j, Y", strtotime($case->created_at)), $_content['calls_cnt'], $_content['emails_cnt'], $_content['chats_cnt'], $_content['reached_cnt'], $_content['forwarded_cnt'], $case->total
            ];
        }

        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'SSE CaseID Logger';
        $data['page_desc'] = 'Log here your overall transactions (caseids) for this day.';
        $data['perfurl'] = 'loadform';
        $data['form_title'] = "Log your cases for " . date("F j, Y");
        return view('tools.formoverview', $data);
    }

    public function store(Request $request) {
        $total = $request->get('calls_cnt') + $request->get('emails_cnt') + $request->get('chats_cnt') + $request->get('reached_cnt') + $request->get('forwarded_cnt');

        $cases = array(
            'calls' => $request->get('calls'),
            'calls_cnt' => $request->get('calls_cnt'),
            'emails' => $request->get('emails'),
            'emails_cnt' => $request->get('emails_cnt'),
            'chats' => $request->get('chats'),
            'chats_cnt' => $request->get('chats_cnt'),
            'reached' => $request->get('reached'),
            'reached_cnt' => $request->get('reached_cnt'),
            'forwarded' => $request->get('forwarded'),
            'forwarded_cnt' => $request->get('forwarded_cnt')
        );

        $insertData = array(
            'content' => json_encode($cases),
            'uid' => Auth::user()->uid,
            'total' => $total
        );

        $data['calls'] = $request->get('calls');
        $data['calls_cnt'] = $request->get('calls_cnt');
        $data['emails'] = $request->get('emails');
        $data['emails_cnt'] = $request->get('emails_cnt');
        $data['chats'] = $request->get('chats');
        $data['chats_cnt'] = $request->get('chats_cnt');
        $data['reached'] = $request->get('reached');
        $data['reached_cnt'] = $request->get('reached_cnt');
        $data['forwarded'] = $request->get('forwarded');
        $data['forwarded_cnt'] = $request->get('forwarded_cnt');
        $data['total'] = $total;

        if (LoggedCases::create($insertData)) {
            $user = Auth::user();

            Mail::send('tools.sendmail', $data, function ($message) use ($user) {
                $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
                $message->to($user->superior->email, $user->superior->name)->subject('1&1 Case Logger');
                $message->cc($user->email, $user->name);
                $message->bcc('lucille.basillote@1and1.com', 'Lucille Basillote');
            });
        }
        return redirect('cases/loadform');
    }

    public function admin() {
        $breakdown = [
            'name' => 'Cases Processed',
            'headers' => ['Logged By', 'Date Created', 'Calls', 'Emails', 'Chats', 'Reached M2P', 'Forwarded M2P', 'Total Cases Processed'],
            'headerStyle' => ['', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $arr = array(21229863, 21230343); //uids with admin access
        $subordinates = in_array(Auth::user()->uid, $arr) ? Employee::all() : Auth::user()->subordinates();

        $data['members'] = $subordinates;
        foreach ($subordinates AS $subordinate) {
            foreach ($subordinate->logged_cases AS $case) {
                $_content = json_decode($case->content, true);
                $breakdown['data'][] = [
                    $case->user->name, date("F j, Y", strtotime($case->created_at)), $_content['calls_cnt'],
                    $_content['emails_cnt'], $_content['chats_cnt'], $_content['reached_cnt'],
                    $_content['forwarded_cnt'], $case->total
                ];
            }
        }

        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'SSE CaseID Logger';
        $data['page_desc'] = 'Log here your overall transactions (caseids) for this day.';
        $data['perfurl'] = 'loadform';
        $data['form_title'] = "Your cases for " . date("F j, Y");
        return view('tools.admin', $data);
    }

    public function generate_csv(Request $request) {
        $arr = array(21229863, 21230343); //uids with admin access
        $subordinates = in_array(Auth::user()->uid, $arr) ? Employee::all() : Auth::user()->subordinates();
        $start = $request->get('date_from');
        $end = $request->get('date_to');

        $_breakdown = [
            'name' => 'Cases Processed',
            'headers' => ['Logged By', 'Date Created', 'Calls', 'Emails', 'Chats', 'Reached M2P', 'Forwarded M2P', '# Calls', '# Emails', '# Chats', '# Reached M2P', '# Forwarded M2P', '# M2P (Reached + Forwarded)', 'Total'],
            'headerStyle' => ['', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''],
            'data' => []
        ];
        
        foreach ($subordinates AS $subordinate) {
            foreach ($subordinate->logged_cases()->dateRange($start, $end)->get() AS $case) {
                $_content = json_decode($case->content, true);
                $calls = explode("\r\n", $_content['calls']);
                $emails = explode("\r\n", $_content['emails']);
                $chats = explode("\r\n", $_content['chats']);
                $reached = explode("\r\n", $_content['reached']);
                $forwarded = explode("\r\n", $_content['forwarded']);

                $_calls = '';
                $_emails = '';
                $_chats = '';
                $_reached = '';
                $_forwarded = '';

                foreach ($calls as $key => $value) {
                    $_calls .= $value . "<br>";
                }

                foreach ($emails as $key => $value) {
                    $_emails .= $value . "<br>";
                }

                foreach ($chats as $key => $value) {
                    $_chats .= $value . "<br>";
                }

                foreach ($reached as $key => $value) {
                    $_reached .= $value . "<br>";
                }

                foreach ($forwarded as $key => $value) {
                    $_forwarded .= $value . "<br>";
                }

                $_breakdown['data'][] = [
                    $subordinate->name, date("F j, Y", strtotime($case->created_at)),
                        $_calls, $_emails, $_chats, $_reached, $_forwarded, $_content['calls_cnt'], $_content['emails_cnt'], $_content['chats_cnt'], $_content['reached_cnt'], $_content['forwarded_cnt'], $_content['reached_cnt'] + $_content['forwarded_cnt'],'<b>'.$case->total.'</b>' 
                ];
            }
        }

        $data['breakdown'] = $_breakdown;

        return view('tools.csvfile', $data);
//        \Excel::create('Cases-' . date("Y-m-d"), function($excel) use($data) {
//            $excel->sheet('Cases Breakdown', function($sheet) use($data) {
//                $sheet->loadView('tools.csvfile', array('data' => $data));
//            });
//        })->download('xlsx');
    }

}
