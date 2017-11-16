<?php

namespace App\Http\Controllers;

use App\USTechPilots as USTechPilots;
use App\US_emails as US_emails;
use \App\US3hReport as US3hReport;
use App\Department as Department;
use App\Employee as Employee;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class MasterReportController extends Controller {

    private $teams;
    private $exemptions;

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
        $data['pilots'] = USTechPilots::get();
        $data['workpools'] = US_emails::get();
        $data['teams'] = Department::orderBy('name', 'asc')->where('market', 'US')->where('departmentid', '!=', 21224109)->get();

        $breakdown = [
            'name' => 'All 3 Hour Reports',
            'headers' => ['Logged By', 'Date Created', 'Date Updated', 'Action', 'Final Report'],
            'headerStyle' => ['', '', '', '', '', ''],
            'data' => []
        ];

        foreach (US3hReport::get() AS $row) {
            $user = Employee::where('uid', $row->logged_by)->first();
            $breakdown['data'][] = [
                $user->name,
                date("F j, Y, g:i a", strtotime($row->created_at)), date("F j, Y, g:i a", strtotime($row->updated_at)),
                '<a href="masterreport/view/' . $row->report_id . '/edit" onclick="window.open(this.href); return false;"><i class="fa fa-fw fa-edit"></i> Modify</a>',
                '<a href="masterreport/view/' . $row->report_id . '/view" onclick="window.open(this.href); return false;"><i class="fa fa-fw fa-external-link"></i> Final Report</a>'
            ];
        }

        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'US Operations 3 Hour Interval Report';
        $data['page_desc'] = 'US Operations 3 Hour Interval Report';
        $data['perfurl'] = 'masterreport';
        return view('3hr.report', $data);
    }

    public function store(Request $request) {
        $availability = array(
            'pilot' => $request->get('pilot'),
            'offered' => $request->get('offered'),
            'sum_offered' => $request->get('sum_offered'),
            'handled' => $request->get('handled'),
            'sum_handled' => $request->get('sum_handled'),
            'overflow_in' => $request->get('overflow_in'),
            'sum_over_in' => $request->get('sum_over_in'),
            'overflow_out' => $request->get('overflow_out'),
            'sum_over_out' => $request->get('sum_over_out')
        );

        $absenteeism = array(
            'deptid' => $request->get('deptid'),
            'expected' => $request->get('expected'),
            'sum_expected' => $request->get('sum_expected'),
            'planned' => $request->get('planned'),
            'sum_planned' => $request->get('sum_planned'),
            'unplanned' => $request->get('unplanned'),
            'sum_unplanned' => $request->get('sum_unplanned')
        );

        $emails = array(
            'workpool' => $request->get('workpool'),
            'emails' => $request->get('emails'),
            'sum_emails' => $request->get('sum_emails')
        );

        $products = array(
            'products' => $request->get('products'),
            'upsells' => $request->get('upsells')
        );

        $sas = array(
            'group' => $request->get('group'),
            'sas_cnt' => $request->get('sas_cnt')
        );

        $details = array(
            'logged_by' => Auth::user()->uid,
            'availability' => json_encode($availability),
            'absenteeism' => json_encode($absenteeism),
            'emails' => json_encode($emails),
            'products' => json_encode($products),
            'sas' => json_encode($sas),
            'attachments' => '',
            'highlights' => $request->get('highlights'),
            'lowlights' => $request->get('lowlights')
        );

        US3hReport::create($details);
        return redirect('masterreport');
    }

    public function view($id = FALSE, $action = FALSE) {
        $data['pilots'] = USTechPilots::get();
        $data['workpools'] = US_emails::get();
        $data['teams'] = Department::orderBy('name', 'asc')->where('market', 'US')->where('departmentid', '!=', 21224109)->get();

        foreach (US3hReport::where('report_id', $id)->get() AS $detail) {
            $data['logged_by'] = $detail->logged_by;
            $availability = json_decode($detail->availability);
            $absenteeism = json_decode($detail->absenteeism);
            $email = json_decode($detail->emails);
            $product = json_decode($detail->products);
            $sas = json_decode($detail->sas);
            $data['highlights'] = $detail->highlights;
            $data['lowlights'] = $detail->lowlights;
        }

        //Availability
        $data['pilot'] = $availability->pilot;
        $data['offered'] = $availability->offered;
        $data['handled'] = $availability->handled;
        $data['overflow_in'] = $availability->overflow_in;
        $data['overflow_out'] = $availability->overflow_out;
        $data['sum_offered'] = $availability->sum_offered;
        $data['sum_handled'] = $availability->sum_handled;
        $data['sum_over_in'] = $availability->sum_over_in;
        $data['sum_over_out'] = $availability->sum_over_out;

        //Absenteeism
        $data['deptid'] = $absenteeism->deptid;
        $data['expected'] = $absenteeism->expected;
        $data['sum_expected'] = $absenteeism->sum_expected;
        $data['planned'] = $absenteeism->planned;
        $data['sum_planned'] = $absenteeism->sum_planned;
        $data['unplanned'] = $absenteeism->unplanned;
        $data['sum_unplanned'] = $absenteeism->sum_unplanned;

        //Emails
        $data['workpool'] = $email->workpool;
        $data['emails'] = $email->emails;
        $data['sum_emails'] = $email->sum_emails;

        //Products
        $data['products'] = $product->products;
        $data['upsells'] = $product->upsells;

        //SAS
        $data['group'] = $sas->group;
        $data['sas_cnt'] = $sas->sas_cnt;

        $data['page_title'] = 'US Operations 3 Hour Interval Report';
        $data['page_desc'] = 'US Operations 3 Hour Interval Report';

        return view(($action == "edit") ? '3hr.view' : '3hr.final', $data);
    }

}
