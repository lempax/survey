<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class PerformanceController extends Controller {

    private $teams;
    private $exemptions;

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

    public function prod(Request $request) {
        $wk = $request->has('w') ? $request->get('w') : false;
        $team_selection = [];
        $cases = array(
            'data' => '',
            'name' => 'Productivity Overview',
            'yLabel' => 'Calls + Emails',
            'xLabel' => 'Total Productivity'
        );
        $consolidated = [
            'name' => 'Calls vs Emails',
            'd1Name' => 'Calls',
            'd2Name' => 'Emails'
        ];
        $entries = [];
        switch (Auth::user()->roles) {
            case 'SAS':
                $entries = \App\Department::where('name', 'like', '%UK Web Hosting %')->get();
                break;
            case 'MANAGER':
            case 'SOM':
                $_entries = $this->teams->reject(function($value) {
                    return in_array($value->departmentid, $this->exemptions);
                });
                $team_selection = $_entries->lists('name', 'departmentid')->sort();
                if ($request->has('deptid')) {
                    $_t = $_entries->where('departmentid', (int) $request->get('deptid'))->first();
                    if ($_t == NULL)
                        $entries = $_entries;
                    else {
                        $entries = $_t->members->get();
                        $entries->push($_t->head);
                    }
                } else
                    $entries = $_entries;
                break;
            case 'SUPERVISOR':
            case 'AGENT':
                if (Auth::user()->roles == 'SUPERVISOR') {
                    $_entries = Auth::user()->subordinates();
                    $_entries->push(Auth::user());
                } else {
                    $_entries = Auth::user()->superior->subordinates();
                    $_entries->push(Auth::user()->superior);
                }
                $entries = $_entries->reject(function($value) {
                    return in_array($value->uid, $this->exemptions);
                });
                break;
            default:
                break;
        }

        $_cases = [];
        foreach ($entries as $entry) {
            if ($request->has('date_start') && $request->has('date_end')) {
                $start = $request->get('date_start');
                $end = $request->get('date_end');
                $_cases[] = [
                    'total' => $entry->cases()->dateRange($start, $end)->sum('case_count'),
                    'data1' => $entry->cases()->dateRange($start, $end)->calls()->sum('case_count'),
                    'data2' => $entry->cases()->dateRange($start, $end)->emails()->sum('case_count'),
                    'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                    'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
                ];
            } else {
                $_cases[] = [
                    'total' => $entry->cases()->weekly($wk)->sum('case_count'),
                    'data1' => $entry->cases()->weekly($wk)->calls()->sum('case_count'),
                    'data2' => $entry->cases()->weekly($wk)->emails()->sum('case_count'),
                    'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                    'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
                ];
            }
        }
        rsort($_cases);
        $cases['data'] = $_cases;

        $data['page_title'] = 'Productivity';
        $data['page_desc'] = 'Shows productivity data overview for the current week.';
        $data['team_selection'] = $team_selection;
        $data['perfurl'] = 'productivity';
        $data['overview'] = $cases;
        $data['consolidated'] = $consolidated;
        //dd($data);
        return view('perfmanagement.dataoverview', $data);
    }

    public function crr(Request $request) {
        $wk = $request->has('w') ? $request->get('w') : false;
        $team_selection = [];
        $qfb = array(
            'data' => '',
            'name' => 'CRR Rating',
            'yLabel' => 'CRR',
            'xLabel' => 'CRR Rating'
        );
        $consolidated = [
            'name' => 'Total Returns over Yes Count',
            'd1Name' => 'Returns',
            'd2Name' => 'Yes'
        ];

        $entries = [];
        switch (Auth::user()->roles) {
            case 'SAS':
                $entries = \App\Department::where('name', 'like', '%UK Web Hosting %')->get();
                break;
            case 'MANAGER':
            case 'SOM':
                $_entries = $this->teams->reject(function($value) {
                    return in_array($value->departmentid, $this->exemptions);
                });
                $team_selection = $_entries->lists('name', 'departmentid')->sort();
                if ($request->has('deptid')) {
                    $_t = $this->teams->where('departmentid', (int) $request->get('deptid'))->first();
                    if ($_t == NULL)
                        $entries = $_entries;
                    else {
                        $entries = $_t->members->get();
                        $entries->push($_t->head);
                    }
                } else
                    $entries = $_entries;
                break;
            case 'SUPERVISOR':
            case 'AGENT':
                if (Auth::user()->roles == 'SUPERVISOR') {
                    $_entries = Auth::user()->subordinates();
                    $_entries->push(Auth::user());
                } else {
                    $_entries = Auth::user()->superior->subordinates();
                    $_entries->push(Auth::user()->superior);
                }
                $entries = $_entries->reject(function($value) {
                    return in_array($value->uid, $this->exemptions);
                });
                break;
            default:
                break;
        }

        $breakdown = [
            'name' => 'QFB Breakdown ' . ($wk ? 'Week [' . date('W') : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Name', 'Medium', 'CaseID', 'Comp.', '1st Request', 'Friend.', 'Effort', 'Req. Solved', 'Response', 'Sol.', 'NPS', 'Comment Praise', 'Comment Suggestions'],
            'headerStyle' => ['', '', '', '', '', '', '', '', '', '', '', '', '', ''],
            'data' => []
        ];
        $_feedbacks = [];
        foreach ($entries as $entry) {
            if ($request->has('date_start') && $request->has('date_end')) {
                $start = $request->get('date_start');
                $end = $request->get('date_end');
                $returns = $entry->feedbacks()->dateRange($start, $end)->count();
                $yes_count = $entry->feedbacks()->dateRange($start, $end)->requestSolved()->count();
            } else {
                $returns = $entry->feedbacks()->weekly($wk)->count();
                $yes_count = $entry->feedbacks()->weekly($wk)->requestSolved()->count();
            }

            $_feedbacks[] = [
                'total' => $returns ? round(($yes_count / $returns) * 100, 2) : 0,
                'data1' => $returns,
                'data2' => $yes_count,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            if ($entry instanceof \App\Employee && $returns) {
                if ($request->has('date_start') && $request->has('date_end'))
                    $feedbacks = $entry->feedbacks()->dateRange($start, $end);
                else
                    $feedbacks = $entry->feedbacks()->weekly($wk);

                if (Auth::user()->roles != 'AGENT') {
                    foreach ($feedbacks->get() as $feeds) {
                        $breakdown['data'][] = [
                            $feeds->date, $feeds->agent_name, $feeds->medium, $feeds->caseid, $feeds->qfb_competence,
                            $feeds->qfb_first_request, $feeds->qfb_friendliness, $feeds->qfb_request_customer_effort_contact,
                            $feeds->qfb_request_resolved, $feeds->qfb_response, $feeds->qfb_solution, $feeds->qfb_netpromoter_score,
                            $feeds->qfb_comment_praise, $feeds->qfb_comment_suggestions
                        ];
                    }
                } else {
                    if (Auth::user()->uid == $entry->uid) {
                        foreach ($feedbacks->get() as $feeds) {
                            $breakdown['data'][] = [
                                $feeds->date, $feeds->agent_name, $feeds->medium, $feeds->caseid, $feeds->qfb_competence,
                                $feeds->qfb_first_request, $feeds->qfb_friendliness, $feeds->qfb_request_customer_effort_contact,
                                $feeds->qfb_request_resolved, $feeds->qfb_response, $feeds->qfb_solution, $feeds->qfb_netpromoter_score,
                                $feeds->qfb_comment_praise, $feeds->qfb_comment_suggestions
                            ];
                        }
                    }
                }
            }
        }
        if (count($breakdown['data'])) {
            $data['breakdown'] = $breakdown;
        }
        rsort($_feedbacks);
        $qfb['data'] = $_feedbacks;

        $data['page_title'] = 'Quality Feedbacks';
        $data['page_desc'] = 'Shows Quality Feedbacks data overview for the current week.';
        $data['team_selection'] = $team_selection;
        $data['perfurl'] = 'feedbacks';
        $data['overview'] = $qfb;
        $data['consolidated'] = $consolidated;
        return view('perfmanagement.dataoverview', $data);
    }

    public function blacklists(Request $request) {
        $wk = $request->has('w') ? $request->get('w') : false;
        $team_selection = [];
        $bl_rating = array(
            'data' => '',
            'name' => 'Blacklist Rating',
            'yLabel' => 'Percentage (%)',
            'xLabel' => 'Blacklist Rating'
        );
        $consolidated = [
            'name' => 'Total Cases over Total Blacklists',
            'd1Name' => 'Cases',
            'd2Name' => 'Blacklists'
        ];

        $entries = [];
        switch (Auth::user()->roles) {
            case 'SAS':
                $entries = \App\Department::where('name', 'like', '%UK Web Hosting %')->get();
                break;
            case 'MANAGER':
            case 'SOM':
                $_entries = $this->teams->reject(function($value) {
                    return in_array($value->departmentid, $this->exemptions);
                });
                $team_selection = $_entries->lists('name', 'departmentid')->sort();
                if ($request->has('deptid')) {
                    $_t = $this->teams->where('departmentid', (int) $request->get('deptid'))->first();
                    if ($_t == NULL)
                        $entries = $_entries;
                    else {
                        $entries = $_t->members->get();
                        $entries->push($_t->head);
                    }
                } else
                    $entries = $_entries;
                break;
            case 'SUPERVISOR':
            case 'AGENT':
                if (Auth::user()->roles == 'SUPERVISOR') {
                    $_entries = Auth::user()->subordinates();
                    $_entries->push(Auth::user());
                } else {
                    $_entries = Auth::user()->superior->subordinates();
                    $_entries->push(Auth::user()->superior);
                }
                $entries = $_entries->reject(function($value) {
                    return in_array($value->uid, $this->exemptions);
                });
                break;
            default:
                break;
        }

        $breakdown = [
            'name' => 'Blacklist Trackings of Agents [' . ($wk ? 'Week [' . date('W') : ($request->has('date_start') && $request->has('date_end') ? 'Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Employee Name', 'Tracking 1', 'Tracking 2', 'Blacklist Count', 'Cases Count'],
            'headerStyle' => ['width: 100px;', 'width: 36%;', 'width: 38%;', 'width: 55px;', 'width: 55px;'],
            'data' => []
        ];

        $overview_top10 = [
            'name' => 'Top 10 Blacklists [' . ($wk ? 'Week [' . date('W') : ($request->has('date_start') && $request->has('date_end') ? 'Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Tracking 1', 'Tracking 2', 'Count'],
            'headerStyle' => ['', '', ''],
            'data' => []
        ];

        $_blacklisted = [];

        if ($request->has('date_start') && $request->has('date_end')) {
            $start = $request->get('date_start');
            $end = $request->get('date_end');
            $top_10 = \App\SSECase::blacklisted()->select(\DB::raw('tracking1, tracking2, COUNT(bl_count) AS total_bl'))->groupBy('tracking1', 'tracking2')->dateRange($start, $end)->orderBy('total_bl', 'DESC')->limit(10);
        } else
            $top_10 = \App\SSECase::blacklisted()->select(\DB::raw('tracking1, tracking2, COUNT(bl_count) AS total_bl'))->groupBy('tracking1', 'tracking2')->weekly($wk)->orderBy('total_bl', 'DESC')->limit(10);

        if (Auth::user()->roles != 'AGENT') {
            foreach ($top_10->get() as $_top_10) {
                $overview_top10['data'][] = [
                    $_top_10->tracking1, $_top_10->tracking2, $_top_10->total_bl
                ];
            }
        }

        foreach ($entries as $entry) {
            if ($request->has('date_start') && $request->has('date_end')) {
                $blacklists = $entry->cases()->dateRange($start, $end)->blackListed()->sum('case_count');
                $case_count = $entry->cases()->dateRange($start, $end)->sum('case_count');
            } else {
                $blacklists = $entry->cases()->weekly($wk)->blackListed()->sum('case_count');
                $case_count = $entry->cases()->weekly($wk)->sum('case_count');
            }

            $_blacklisted[] = [
                'total' => $blacklists ? round(($blacklists / $case_count) * 100, 2) : 0,
                'data1' => $case_count,
                'data2' => $blacklists,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            if ($entry instanceof \App\Employee && $blacklists) {
                if ($request->has('date_start') && $request->has('date_end'))
                    $feedbacks = $entry->cases()->dateRange($start, $end)->blackListed()->select(\DB::raw('agent_name, GROUP_CONCAT(DISTINCT tracking1 SEPARATOR " , ") AS tracking_1, GROUP_CONCAT(DISTINCT tracking2 SEPARATOR " , ") AS tracking_2'))->groupby('uid');
                else
                    $feedbacks = $entry->cases()->weekly($wk)->blackListed()->select(\DB::raw('agent_name, GROUP_CONCAT(DISTINCT tracking1 SEPARATOR " , ") AS tracking_1, GROUP_CONCAT(DISTINCT tracking2 SEPARATOR " , ") AS tracking_2'))->groupby('uid');

                if (Auth::user()->roles != 'AGENT') {
                    foreach ($feedbacks->get() as $feeds) {
                        $breakdown['data'][] = [
                            $feeds->agent_name, $feeds->tracking_1, $feeds->tracking_2, $blacklists, $case_count
                        ];
                    }
                } else {
                    if (Auth::user()->uid == $entry->uid) {
                        foreach ($feedbacks->get() as $feeds) {
                            $breakdown['data'][] = [
                                $feeds->agent_name, $feeds->tracking_1, $feeds->tracking_2, $blacklists, $case_count
                            ];
                        }
                    }
                }
            }
        }

        if (count($breakdown['data'])) {
            $data['breakdown'] = $breakdown;
        } else if (count($overview_top10['data'])) {
            $data['overview_table'] = $overview_top10;
        }

        rsort($_blacklisted);
        $bl_rating['data'] = $_blacklisted;

        $data['page_title'] = 'Blacklist Rating';
        $data['page_desc'] = 'Shows blacklist data overview for the current week.';
        $data['team_selection'] = $team_selection;
        $data['perfurl'] = 'blacklist';
        $data['overview'] = $bl_rating;
        $data['consolidated'] = $consolidated;
        return view('perfmanagement.dataoverview', $data);
    }

    public function sales(Request $request) {
        $wk = $request->has('w') ? $request->get('w') : false;
        $team_selection = [];
        $sas = array(
            'data' => '',
            'name' => 'SAS Upsells Overview',
            'yLabel' => 'Upsells',
            'xLabel' => 'SAS Rating'
        );
        $consolidated = [
            'name' => 'Total Upsells over SAS Conversion Rate',
            'd1Name' => 'Upsells',
            'd2Name' => 'Conversion Rate'
        ];

        $entries = [];
        switch (Auth::user()->roles) {
            case 'SAS':
                $entries = \App\Department::where('name', 'like', '%UK Web Hosting %')->get();
                break;
            case 'MANAGER':
            case 'SOM':
                $_entries = $this->teams->reject(function($value) {
                    return in_array($value->departmentid, $this->exemptions);
                });
                $team_selection = $_entries->lists('name', 'departmentid')->sort();
                if ($request->has('deptid')) {
                    $_t = $this->teams->where('departmentid', (int) $request->get('deptid'))->first();
                    if ($_t == NULL)
                        $entries = $_entries;
                    else {
                        $entries = $_t->members->get();
                        $entries->push($_t->head);
                    }
                } else
                    $entries = $_entries;
                break;
            case 'SUPERVISOR':
            case 'AGENT':
                if (Auth::user()->roles == 'SUPERVISOR') {
                    $_entries = Auth::user()->subordinates();
                    $_entries->push(Auth::user());
                } else {
                    $_entries = Auth::user()->superior->subordinates();
                    $_entries->push(Auth::user()->superior);
                }
                $entries = $_entries->reject(function($value) {
                    return in_array($value->uid, $this->exemptions);
                });
                break;
            default:
                break;
        }

        $breakdown = [
            'name' => 'SAS Upsells Breakdown [' . ($wk ? 'Week [' . date('W') : ($request->has('date_start') && $request->has('date_end') ? 'Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Name', 'Contract ID', 'Customer ID', 'Product ID', 'Product Description', 'Team'],
            'headerStyle' => ['width: 50px;', 'width: 150px;', 'width: 40px;', 'width: 50px;', 'width: 80px;', 'min-width: 200px;', ''],
            'data' => []
        ];
        $overview_zerosellers = [
            'name' => 'ZeroSellers [' . ($wk ? 'Week [' . date('W') : ($request->has('date_start') && $request->has('date_end') ? 'Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Name', 'Team'],
            'headerStyle' => ['', '', ''],
            'data' => []
        ];

        if ($request->has('date_start') && $request->has('date_end')) {
            $start = $request->get('date_start');
            $end = $request->get('date_end');
            $zero = \App\SASUpsells::invalid()->select(\DB::raw('firstname,lastname,department'))->groupBy('firstname', 'lastname')->dateRange($start, $end)->orderBy('firstname', 'DESC');
        } else
            $zero = \App\SASUpsells::invalid()->select(\DB::raw('firstname,lastname,department'))->groupBy('firstname', 'lastname')->weekly($wk)->orderBy('firstname', 'DESC');

        if (Auth::user()->roles != 'AGENT') {
            foreach ($zero->get() as $_top_10) {
                $overview_zerosellers['data'][] = [
                    $_top_10->firstname . ' ' . $_top_10->lastname, $_top_10->department
                ];
            }
        }


        $_sales = [];
        foreach ($entries as $entry) {
            if ($request->has('date_start') && $request->has('date_end')) {
                $start = $request->get('date_start');
                $end = $request->get('date_end');
                $sales = $entry->upsells()->dateRange($start, $end)->valid()->count();
                $calls = $entry->cases()->dateRange($start, $end)->calls()->sum('case_count');
            } else {
                $sales = $entry->upsells()->weekly($wk)->valid()->count();
                $calls = $entry->cases()->weekly($wk)->calls()->sum('case_count');
            }

            $_sales[] = [
                'total' => $sales ? $sales : 0,
                'data1' => $sales,
                'data2' => $calls ? round(($sales / $calls) * 100, 2) : 0,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            if ($entry instanceof \App\Employee && $sales) {
                if ($request->has('date_start') && $request->has('date_end'))
                    $upsells = $entry->upsells()->dateRange($start, $end);
                else
                    $upsells = $entry->upsells()->weekly($wk);

                if (Auth::user()->roles != 'AGENT') {
                    foreach ($upsells->get() as $feeds) {
                        $breakdown['data'][] = [
                            $feeds->sales_date, $feeds->firstname . ' ' . $feeds->lastname, $feeds->contract_id, $feeds->customer_id,
                            $feeds->product_id, $feeds->product_desc, $feeds->department
                        ];
                    }
                } else {
                    if (Auth::user()->uid == $entry->uid) {
                        foreach ($upsells->get() as $feeds) {
                            $breakdown['data'][] = [
                                $feeds->sales_date, $feeds->firstname . ' ' . $feeds->lastname, $feeds->contract_id, $feeds->customer_id,
                                $feeds->product_id, $feeds->product_desc, $feeds->department
                            ];
                        }
                    }
                }
            }
        }
        if (count($breakdown['data'])) {
            $data['breakdown'] = $breakdown;
        } else if (count($overview_zerosellers['data'])) {
            $data['overview_table'] = $overview_zerosellers;
        }
        rsort($_sales);
        $sas['data'] = $_sales;

        $data['page_title'] = 'SAS Upsells';
        $data['page_desc'] = 'Shows sas upsell data overview for the current week.';
        $data['team_selection'] = $team_selection;
        $data['perfurl'] = 'sasupsells';
        $data['overview'] = $sas;
        $data['consolidated'] = $consolidated;
        return view('perfmanagement.dataoverview', $data);
    }

    public function cosmocom(Request $request) {
        $wk = $request->has('w') ? $request->get('w') : false;
        $team_selection = [];
        $cfb = array(
            'data' => '',
            'name' => 'Cosmocom',
            'yLabel' => 'Released Rate (%)',
            'xLabel' => 'Cosmocom'
        );
        $consolidated = [
            'name' => 'Total vs Average',
            'd1Name' => 'Total',
            'd2Name' => 'Average'
        ];

        $entries = [];
        switch (Auth::user()->roles) {
            case 'SAS':
                $entries = \App\Department::where('name', 'like', '%UK Web Hosting %')->get();
                break;
            case 'MANAGER':
            case 'SOM':
                $_entries = $this->teams->reject(function($value) {
                    return in_array($value->departmentid, $this->exemptions);
                });
                $team_selection = $_entries->lists('name', 'departmentid')->sort();
                if ($request->has('deptid')) {
                    $_t = $this->teams->where('departmentid', (int) $request->get('deptid'))->first();
                    if ($_t == NULL)
                        $entries = $_entries;
                    else {
                        $entries = $_t->members->get();
                        $entries->push($_t->head);
                    }
                } else
                    $entries = $_entries;
                break;
            case 'SUPERVISOR':
            case 'AGENT':
                if (Auth::user()->roles == 'SUPERVISOR') {
                    $_entries = Auth::user()->subordinates();
                    $_entries->push(Auth::user());
                } else {
                    $_entries = Auth::user()->superior->subordinates();
                    $_entries->push(Auth::user()->superior);
                }
                $entries = $_entries->reject(function($value) {
                    return in_array($value->uid, $this->exemptions);
                });
                break;
            default:
                break;
        }

        $breakdown = [
            'name' => 'Cosmocom Breakdown ' . ($wk ? 'Week [' . date('W') : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Name', 'State', 'Duration', 'State Time', 'State Ratio', 'Total Duration'],
            'headerStyle' => ['', '', '', '', '', '', ''],
            'data' => []
        ];
        $_cosmocom = [];
        foreach ($entries as $entry) {
            if ($request->has('date_start') && $request->has('date_end')) {
                $start = $request->get('date_start');
                $end = $request->get('date_end');
                $cosmo = $entry->cosmocom()->dateRange($start, $end)->get();
            } else {
                $cosmo = $entry->cosmocom()->weekly($wk)->get();
                //$rel= round($cosmo->where('state', 'Released')->avg('state_ratio'), 2);
                //$total= round($cosmo->where('state', 'Released')->sum('total_duration'), 2);
                //$avg= round($cosmo->where('state', 'Released')->avg('total_duration'), 2);
            }

            $_cosmocom[] = [
                'total' => round($cosmo->where('state', 'Released')->avg('state_ratio'), 2),
                'data1' => round($cosmo->where('state', 'Released')->sum('total_duration'), 2),
                'data2' => round($cosmo->where('state', 'Released')->avg('total_duration'), 2),
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            if ($entry instanceof \App\Employee && $cosmo) {
                if ($request->has('date_start') && $request->has('date_end'))
                    $cosmocom = $entry->cosmocom()->dateRange($start, $end);
                else
                    $cosmocom = $entry->cosmocom()->weekly($wk);

                if (Auth::user()->roles != 'AGENT') {
                    foreach ($cosmocom->get() as $cosmo) {
                        $breakdown['data'][] = [
                            $cosmo->date, $cosmo->agent_name, $cosmo->state, $cosmo->duration, $cosmo->avg_statetime,
                            $cosmo->state_ratio, $cosmo->total_duration
                        ];
                    }
                } else {
                    if (Auth::user()->uid == $entry->uid) {
                        foreach ($cosmocom->get() as $cosmo) {
                            $breakdown['data'][] = [
                                $cosmo->date, $cosmo->agent_name, $cosmo->state, $cosmo->duration, $cosmo->avg_statetime,
                                $cosmo->state_ratio, $cosmo->total_duration
                            ];
                        }
                    }
                }
            }
        }
        if (count($breakdown['data'])) {
            $data['breakdown'] = $breakdown;
        }
        rsort($_cosmocom);
        $cfb['data'] = $_cosmocom;

        $data['page_title'] = 'Cosmocom';
        $data['page_desc'] = 'Shows Cosmocom data overview for the current week.';
        $data['team_selection'] = $team_selection;
        $data['perfurl'] = 'cosmocom';
        $data['overview'] = $cfb;
        $data['consolidated'] = $consolidated;
        return view('perfmanagement.dataoverview', $data);
    }

    public function sas_breakdown(Request $request) {
        $wk = $request->has('w') ? $request->get('w') : false;
        $team_selection = [];
        $sales = array(
            'data' => '',
            'name' => 'Sales Overview',
            'yLabel' => 'GO + FO',
            'xLabel' => 'Total Sales (GO + FO)'
        );
        $gofo = [
            'name' => 'GO vs FO',
            'd1Name' => 'GO +',
            'd2Name' => 'FO +'
        ];

        $entries = [];
        switch (Auth::user()->roles) {
            case 'SAS':
                $entries = \App\Department::where('name', 'like', '%UK Web Hosting %')->get();
                    break;
            case 'MANAGER':
            case 'SOM':
                $_entries = $this->teams->reject(function($value) {
                    return in_array($value->departmentid, $this->exemptions);
                });
                $team_selection = $_entries->lists('name', 'departmentid')->sort();
                if ($request->has('deptid')) {
                    $_t = $this->teams->where('departmentid', (int) $request->get('deptid'))->first();
                    if ($_t == NULL)
                        $entries = $_entries;
                    else {
                        $entries = $_t->members->get();
                        $entries->push($_t->head);
                    }
                } else
                    $entries = $_entries;
                break;
            case 'SUPERVISOR':
            case 'AGENT':
                if (Auth::user()->roles == 'SUPERVISOR') {
                    $_entries = Auth::user()->subordinates();
                    $_entries->push(Auth::user());
                } else {
                    $_entries = Auth::user()->superior->subordinates();
                    $_entries->push(Auth::user()->superior);
                }
                $entries = $_entries->reject(function($value) {
                    return in_array($value->uid, $this->exemptions);
                });
                break;
            default:
                break;
        }

        $breakdown = [
            'name' => 'SAS Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Sales Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $sas_table = [
            'name' => 'SAS Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Team', 'Calls', 'Sales GO + FO', 'GO +', 'FO +', 'CR GO+FO (Sales/Calls)'],
            'headerStyle' => ['', '', '', '', '', ''],
            'data' => []
        ];

        $_sales = [];
        foreach ($entries as $entry) {
            if ($request->has('date_start') && $request->has('date_end')) {
                $start = $request->get('date_start');
                $end = $request->get('date_end');
                $fo = $entry->upsells()->dateRange($start, $end)->valid()->fo()->count();
                $go = $entry->upsells()->dateRange($start, $end)->valid()->go()->count();
                $calls = $entry->cases()->calls()->dateRange($start, $end)->sum('case_count');
            } else {
                $fo = $entry->upsells()->weekly($wk)->valid()->fo()->count();
                $go = $entry->upsells()->weekly($wk)->valid()->go()->count();
                $calls = $entry->cases()->calls()->weekly($wk)->sum('case_count');
            }
            $total = $fo + $go;
            
            $sas_table['data'][] = [
                $entry->name, $calls, $total, $go, $fo, $total ? round((($total) / $calls) * 100, 2) . ' %' : 0 . ' %'
            ];

            $_sales[] = [
                'total' => round($fo + $go),
                'data1' => $fo,
                'data2' => $go,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            if ($entry instanceof \App\Employee) {
                if ($request->has('date_start') && $request->has('date_end')) {
                    $fo = $entry->upsells()->dateRange($start, $end)->valid()->fo()->count();
                    $go = $entry->upsells()->dateRange($start, $end)->valid()->go()->count();
                    $sas = $entry->upsells()->dateRange($start, $end)->valid()->transaction();
                } else {
                    $fo = $entry->upsells()->weekly($wk)->valid()->fo()->count();
                    $go = $entry->upsells()->weekly($wk)->valid()->go()->count();
                    $sas = $entry->upsells()->weekly($wk)->valid()->transaction();
                }

                if (Auth::user()->roles != 'AGENT') {
                    foreach ($sas->get() as $_sas) {
                        $breakdown['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }
                } else {
                    if (Auth::user()->uid == $entry->uid) {
                        foreach ($sas->get() as $_sas) {
                            $breakdown['data'][] = [
                                $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                                $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                            ];
                        }
                    }
                }
            }
        }

        if (count($breakdown['data'])) {
            $data['breakdown'] = $breakdown;
        } else if (count($sas_table['data'])) {
            $data['overview_table'] = $sas_table;
        }

        rsort($_sales);
        $sales['data'] = $_sales;

        $data['page_title'] = 'SAS Visibility';
        $data['page_desc'] = 'Shows GO, FO, SAS MC, SAS TC data overview for the current week.';
        $data['team_selection'] = $team_selection;
        $data['perfurl'] = 'sasbreakdown';
        $data['overview'] = $sales;
        $data['consolidated'] = $gofo;
        return view('perfmanagement.dataoverview', $data);
    }

}
