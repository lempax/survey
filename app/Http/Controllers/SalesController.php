<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use Excel;
use App\Employee;
use App\Saspayout;
use App\SASTargets;
use App\SasPayoutBreakdown;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller {

    private $teams;
    private $exemptions;

    public function __construct() {
        $this->middleware('auth');
        if (Auth::check()) {
            $_team = Auth::user()->teams();
            if ($_team->count() == 1 && $_team->first()->departmentid = 21395000)
                $this->teams = \App\Department::where('name', 'like', 'U%')->get();
            else
                switch (Auth::user()->departmentid) {
                    case 21395000:
                        $this->teams = \App\Department::where('name', 'like', '%UK Web Hosting %')->get();
                        break;
                    case 21437605:
                        $this->teams = \App\Department::where('name', 'like', '%US Web Hosting %')->get();
                        break;
                    default:
                        $this->teams = Auth::user()->teams();
                        break;
                }

            $this->exemptions = Auth::user()->settings()->type('filtered_list')->first() ?
                    json_decode(Auth::user()->settings()->type('filtered_list')->first()->entries) : [];
        }
    }

    public function index(Request $request) {
        $wk = $request->has('w') ? $request->get('w') : false;
        $team_selection = [];
        $entries = [];

        switch (Auth::user()->roles) {
            case 'SAS':
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
                $_entries = Auth::user()->subordinates();
                $_entries->push(Auth::user());

                $entries = $_entries->reject(function($value) {
                    return in_array($value->uid, $this->exemptions);
                });
            case 'AGENT':
                $entry = Auth::user();
                break;
            default:
                break;
        }

        $sas_table = [
            'name' => 'Gross Order ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Name', 'Calls', 'Listlocal', 'Cloud Server', 'Dedicated Server', 'VPS', 'Classic Hosting', 'MyWebsite', 'E-mail', 'E-Business', 'Online Marketing', 'Office', 'Domains', 'Total'],
            'headerStyle' => ['', '', '', '', '', '', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown = [
            'name' => 'Featured Order ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Name', 'Calls', 'Listlocal', 'Cloud Server', 'Dedicated Server', 'VPS', 'Classic Hosting', 'MyWebsite', 'E-mail', 'E-Business', 'Online Marketing', 'Office', 'Domains', 'Total'],
            'headerStyle' => ['', '', '', '', '', '', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $sastc = [
            'name' => 'Tarrif Change ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Name', 'Calls', 'Listlocal', 'Cloud Server', 'Dedicated Server', 'VPS', 'Classic Hosting', 'MyWebsite', 'E-mail', 'E-Business', 'Online Marketing', 'Office', 'Domains', 'Total'],
            'headerStyle' => ['', '', '', '', '', '', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        if (Auth::user()->roles == 'AGENT') {
            if ($request->has('date_start') && $request->has('date_end')) {
                $start = $request->get('date_start');
                $end = $request->get('date_end');
                $fo = $entry->upsells()->dateRange($start, $end)->valid()->fo()->count();
                $go = $entry->upsells()->dateRange($start, $end)->valid()->go()->count();
                $sas = $entry->upsells()->dateRange($start, $end)->sastc()->count();
                $calls = $entry->cases()->calls()->dateRange($start, $end)->sum('case_count');

                //GO Products

                $go_listlocal = $entry->upsells()->dateRange($start, $end)->valid()->go()->listlocal()->count();
                $go_cloudserver = $entry->upsells()->dateRange($start, $end)->valid()->go()->cloudserver()->count();
                $go_dedicated = $entry->upsells()->dateRange($start, $end)->valid()->go()->dedicated()->count();
                $go_vps = $entry->upsells()->dateRange($start, $end)->valid()->go()->vps()->count();
                $go_classic = $entry->upsells()->dateRange($start, $end)->valid()->go()->classic()->count();
                $go_mywebsite = $entry->upsells()->dateRange($start, $end)->valid()->go()->mywebsite()->count();
                $go_email = $entry->upsells()->dateRange($start, $end)->valid()->go()->email()->count();
                $go_ebusiness = $entry->upsells()->dateRange($start, $end)->valid()->go()->ebusiness()->count();
                $go_marketing = $entry->upsells()->dateRange($start, $end)->valid()->go()->marketing()->count();
                $go_office = $entry->upsells()->dateRange($start, $end)->valid()->go()->office()->count();
                $go_domains = $entry->upsells()->dateRange($start, $end)->valid()->go()->domains()->count();

                //FO Products

                $fo_listlocal = $entry->upsells()->dateRange($start, $end)->valid()->fo()->listlocal()->count();
                $fo_cloudserver = $entry->upsells()->dateRange($start, $end)->valid()->fo()->cloudserver()->count();
                $fo_dedicated = $entry->upsells()->dateRange($start, $end)->valid()->fo()->dedicated()->count();
                $fo_vps = $entry->upsells()->dateRange($start, $end)->valid()->fo()->vps()->count();
                $fo_classic = $entry->upsells()->dateRange($start, $end)->valid()->fo()->classic()->count();
                $fo_mywebsite = $entry->upsells()->dateRange($start, $end)->valid()->fo()->mywebsite()->count();
                $fo_email = $entry->upsells()->dateRange($start, $end)->valid()->fo()->email()->count();
                $fo_ebusiness = $entry->upsells()->dateRange($start, $end)->valid()->fo()->ebusiness()->count();
                $fo_marketing = $entry->upsells()->dateRange($start, $end)->valid()->fo()->marketing()->count();
                $fo_office = $entry->upsells()->dateRange($start, $end)->valid()->fo()->office()->count();
                $fo_domains = $entry->upsells()->dateRange($start, $end)->valid()->fo()->domains()->count();

                //TC Products

                $tc_listlocal = $entry->upsells()->dateRange($start, $end)->sastc()->listlocal()->count();
                $tc_cloudserver = $entry->upsells()->dateRange($start, $end)->sastc()->cloudserver()->count();
                $tc_dedicated = $entry->upsells()->dateRange($start, $end)->sastc()->dedicated()->count();
                $tc_vps = $entry->upsells()->dateRange($start, $end)->sastc()->vps()->count();
                $tc_classic = $entry->upsells()->dateRange($start, $end)->sastc()->classic()->count();
                $tc_mywebsite = $entry->upsells()->dateRange($start, $end)->sastc()->mywebsite()->count();
                $tc_email = $entry->upsells()->dateRange($start, $end)->sastc()->email()->count();
                $tc_ebusiness = $entry->upsells()->dateRange($start, $end)->sastc()->ebusiness()->count();
                $tc_marketing = $entry->upsells()->dateRange($start, $end)->sastc()->marketing()->count();
                $tc_office = $entry->upsells()->dateRange($start, $end)->sastc()->office()->count();
                $tc_domains = $entry->upsells()->dateRange($start, $end)->sastc()->domains()->count();
            } else {
                $calls = $entry->cases()->calls()->weekly($wk)->sum('case_count');
                $fo = $entry->upsells()->weekly($wk)->valid()->fo()->count();
                $go = $entry->upsells()->weekly($wk)->valid()->go()->count();
                $sas = $entry->upsells()->weekly($wk)->sastc()->count();

                //GO Products

                $go_listlocal = $entry->upsells()->weekly($wk)->valid()->go()->listlocal()->count();
                $go_cloudserver = $entry->upsells()->weekly($wk)->valid()->go()->cloudserver()->count();
                $go_dedicated = $entry->upsells()->weekly($wk)->valid()->go()->dedicated()->count();
                $go_vps = $entry->upsells()->weekly($wk)->valid()->go()->vps()->count();
                $go_classic = $entry->upsells()->weekly($wk)->valid()->go()->classic()->count();
                $go_mywebsite = $entry->upsells()->weekly($wk)->valid()->go()->mywebsite()->count();
                $go_email = $entry->upsells()->weekly($wk)->valid()->go()->email()->count();
                $go_ebusiness = $entry->upsells()->weekly($wk)->valid()->go()->ebusiness()->count();
                $go_marketing = $entry->upsells()->weekly($wk)->valid()->go()->marketing()->count();
                $go_office = $entry->upsells()->weekly($wk)->valid()->go()->office()->count();
                $go_domains = $entry->upsells()->weekly($wk)->valid()->go()->domains()->count();

                //FO Products

                $fo_listlocal = $entry->upsells()->weekly($wk)->valid()->fo()->listlocal()->count();
                $fo_cloudserver = $entry->upsells()->weekly($wk)->valid()->fo()->cloudserver()->count();
                $fo_dedicated = $entry->upsells()->weekly($wk)->valid()->fo()->dedicated()->count();
                $fo_vps = $entry->upsells()->weekly($wk)->valid()->fo()->vps()->count();
                $fo_classic = $entry->upsells()->weekly($wk)->valid()->fo()->classic()->count();
                $fo_mywebsite = $entry->upsells()->weekly($wk)->valid()->fo()->mywebsite()->count();
                $fo_email = $entry->upsells()->weekly($wk)->valid()->fo()->email()->count();
                $fo_ebusiness = $entry->upsells()->weekly($wk)->valid()->fo()->ebusiness()->count();
                $fo_marketing = $entry->upsells()->weekly($wk)->valid()->fo()->marketing()->count();
                $fo_office = $entry->upsells()->weekly($wk)->valid()->fo()->office()->count();
                $fo_domains = $entry->upsells()->weekly($wk)->valid()->fo()->domains()->count();

                //TC Products

                $tc_listlocal = $entry->upsells()->weekly($wk)->sastc()->listlocal()->count();
                $tc_cloudserver = $entry->upsells()->weekly($wk)->sastc()->cloudserver()->count();
                $tc_dedicated = $entry->upsells()->weekly($wk)->sastc()->dedicated()->count();
                $tc_vps = $entry->upsells()->weekly($wk)->sastc()->vps()->count();
                $tc_classic = $entry->upsells()->weekly($wk)->sastc()->classic()->count();
                $tc_mywebsite = $entry->upsells()->weekly($wk)->sastc()->mywebsite()->count();
                $tc_email = $entry->upsells()->weekly($wk)->sastc()->email()->count();
                $tc_ebusiness = $entry->upsells()->weekly($wk)->sastc()->ebusiness()->count();
                $tc_marketing = $entry->upsells()->weekly($wk)->sastc()->marketing()->count();
                $tc_office = $entry->upsells()->weekly($wk)->sastc()->office()->count();
                $tc_domains = $entry->upsells()->weekly($wk)->sastc()->domains()->count();
            }

            $sas_table['data'][] = [
                $entry->name, $calls, $go_listlocal, $go_cloudserver, $go_dedicated, $go_vps, $go_classic, $go_mywebsite, $go_email, $go_ebusiness, $go_marketing, $go_office, $go_domains, $go
            ];

            $breakdown['data'][] = [
                $entry->name, $calls, $fo_listlocal, $fo_cloudserver, $fo_dedicated, $fo_vps, $fo_classic, $fo_mywebsite, $fo_email, $fo_ebusiness, $fo_marketing, $fo_office, $fo_domains, $fo
            ];

            $sastc['data'][] = [
                $entry->name, $calls, $tc_listlocal, $tc_cloudserver, $tc_dedicated, $tc_vps, $tc_classic, $tc_mywebsite, $tc_email, $tc_ebusiness, $tc_marketing, $tc_office, $tc_domains, $sas
            ];
        } else {
            foreach ($entries as $entry) {
                if ($request->has('date_start') && $request->has('date_end')) {
                    $start = $request->get('date_start');
                    $end = $request->get('date_end');
                    $fo = $entry->upsells()->dateRange($start, $end)->valid()->fo()->count();
                    $go = $entry->upsells()->dateRange($start, $end)->valid()->go()->count();
                    $sas = $entry->upsells()->dateRange($start, $end)->sastc()->count();
                    $calls = $entry->cases()->calls()->dateRange($start, $end)->sum('case_count');

                    //GO Products

                    $go_listlocal = $entry->upsells()->dateRange($start, $end)->valid()->go()->listlocal()->count();
                    $go_cloudserver = $entry->upsells()->dateRange($start, $end)->valid()->go()->cloudserver()->count();
                    $go_dedicated = $entry->upsells()->dateRange($start, $end)->valid()->go()->dedicated()->count();
                    $go_vps = $entry->upsells()->dateRange($start, $end)->valid()->go()->vps()->count();
                    $go_classic = $entry->upsells()->dateRange($start, $end)->valid()->go()->classic()->count();
                    $go_mywebsite = $entry->upsells()->dateRange($start, $end)->valid()->go()->mywebsite()->count();
                    $go_email = $entry->upsells()->dateRange($start, $end)->valid()->go()->email()->count();
                    $go_ebusiness = $entry->upsells()->dateRange($start, $end)->valid()->go()->ebusiness()->count();
                    $go_marketing = $entry->upsells()->dateRange($start, $end)->valid()->go()->marketing()->count();
                    $go_office = $entry->upsells()->dateRange($start, $end)->valid()->go()->office()->count();
                    $go_domains = $entry->upsells()->dateRange($start, $end)->valid()->go()->domains()->count();

                    //FO Products

                    $fo_listlocal = $entry->upsells()->dateRange($start, $end)->valid()->fo()->listlocal()->count();
                    $fo_cloudserver = $entry->upsells()->dateRange($start, $end)->valid()->fo()->cloudserver()->count();
                    $fo_dedicated = $entry->upsells()->dateRange($start, $end)->valid()->fo()->dedicated()->count();
                    $fo_vps = $entry->upsells()->dateRange($start, $end)->valid()->fo()->vps()->count();
                    $fo_classic = $entry->upsells()->dateRange($start, $end)->valid()->fo()->classic()->count();
                    $fo_mywebsite = $entry->upsells()->dateRange($start, $end)->valid()->fo()->mywebsite()->count();
                    $fo_email = $entry->upsells()->dateRange($start, $end)->valid()->fo()->email()->count();
                    $fo_ebusiness = $entry->upsells()->dateRange($start, $end)->valid()->fo()->ebusiness()->count();
                    $fo_marketing = $entry->upsells()->dateRange($start, $end)->valid()->fo()->marketing()->count();
                    $fo_office = $entry->upsells()->dateRange($start, $end)->valid()->fo()->office()->count();
                    $fo_domains = $entry->upsells()->dateRange($start, $end)->valid()->fo()->domains()->count();

                    //TC Products

                    $tc_listlocal = $entry->upsells()->dateRange($start, $end)->sastc()->listlocal()->count();
                    $tc_cloudserver = $entry->upsells()->dateRange($start, $end)->sastc()->cloudserver()->count();
                    $tc_dedicated = $entry->upsells()->dateRange($start, $end)->sastc()->dedicated()->count();
                    $tc_vps = $entry->upsells()->dateRange($start, $end)->sastc()->vps()->count();
                    $tc_classic = $entry->upsells()->dateRange($start, $end)->sastc()->classic()->count();
                    $tc_mywebsite = $entry->upsells()->dateRange($start, $end)->sastc()->mywebsite()->count();
                    $tc_email = $entry->upsells()->dateRange($start, $end)->sastc()->email()->count();
                    $tc_ebusiness = $entry->upsells()->dateRange($start, $end)->sastc()->ebusiness()->count();
                    $tc_marketing = $entry->upsells()->dateRange($start, $end)->sastc()->marketing()->count();
                    $tc_office = $entry->upsells()->dateRange($start, $end)->sastc()->office()->count();
                    $tc_domains = $entry->upsells()->dateRange($start, $end)->sastc()->domains()->count();
                } else {
                    $calls = $entry->cases()->calls()->weekly($wk)->sum('case_count');
                    $fo = $entry->upsells()->weekly($wk)->valid()->fo()->count();
                    $go = $entry->upsells()->weekly($wk)->valid()->go()->count();
                    $sas = $entry->upsells()->weekly($wk)->sastc()->count();

                    //GO Products

                    $go_listlocal = $entry->upsells()->weekly($wk)->valid()->go()->listlocal()->count();
                    $go_cloudserver = $entry->upsells()->weekly($wk)->valid()->go()->cloudserver()->count();
                    $go_dedicated = $entry->upsells()->weekly($wk)->valid()->go()->dedicated()->count();
                    $go_vps = $entry->upsells()->weekly($wk)->valid()->go()->vps()->count();
                    $go_classic = $entry->upsells()->weekly($wk)->valid()->go()->classic()->count();
                    $go_mywebsite = $entry->upsells()->weekly($wk)->valid()->go()->mywebsite()->count();
                    $go_email = $entry->upsells()->weekly($wk)->valid()->go()->email()->count();
                    $go_ebusiness = $entry->upsells()->weekly($wk)->valid()->go()->ebusiness()->count();
                    $go_marketing = $entry->upsells()->weekly($wk)->valid()->go()->marketing()->count();
                    $go_office = $entry->upsells()->weekly($wk)->valid()->go()->office()->count();
                    $go_domains = $entry->upsells()->weekly($wk)->valid()->go()->domains()->count();

                    //FO Products

                    $fo_listlocal = $entry->upsells()->weekly($wk)->valid()->fo()->listlocal()->count();
                    $fo_cloudserver = $entry->upsells()->weekly($wk)->valid()->fo()->cloudserver()->count();
                    $fo_dedicated = $entry->upsells()->weekly($wk)->valid()->fo()->dedicated()->count();
                    $fo_vps = $entry->upsells()->weekly($wk)->valid()->fo()->vps()->count();
                    $fo_classic = $entry->upsells()->weekly($wk)->valid()->fo()->classic()->count();
                    $fo_mywebsite = $entry->upsells()->weekly($wk)->valid()->fo()->mywebsite()->count();
                    $fo_email = $entry->upsells()->weekly($wk)->valid()->fo()->email()->count();
                    $fo_ebusiness = $entry->upsells()->weekly($wk)->valid()->fo()->ebusiness()->count();
                    $fo_marketing = $entry->upsells()->weekly($wk)->valid()->fo()->marketing()->count();
                    $fo_office = $entry->upsells()->weekly($wk)->valid()->fo()->office()->count();
                    $fo_domains = $entry->upsells()->weekly($wk)->valid()->fo()->domains()->count();

                    //TC Products

                    $tc_listlocal = $entry->upsells()->weekly($wk)->sastc()->listlocal()->count();
                    $tc_cloudserver = $entry->upsells()->weekly($wk)->sastc()->cloudserver()->count();
                    $tc_dedicated = $entry->upsells()->weekly($wk)->sastc()->dedicated()->count();
                    $tc_vps = $entry->upsells()->weekly($wk)->sastc()->vps()->count();
                    $tc_classic = $entry->upsells()->weekly($wk)->sastc()->classic()->count();
                    $tc_mywebsite = $entry->upsells()->weekly($wk)->sastc()->mywebsite()->count();
                    $tc_email = $entry->upsells()->weekly($wk)->sastc()->email()->count();
                    $tc_ebusiness = $entry->upsells()->weekly($wk)->sastc()->ebusiness()->count();
                    $tc_marketing = $entry->upsells()->weekly($wk)->sastc()->marketing()->count();
                    $tc_office = $entry->upsells()->weekly($wk)->sastc()->office()->count();
                    $tc_domains = $entry->upsells()->weekly($wk)->sastc()->domains()->count();
                }

                $sas_table['data'][] = [
                    $entry->name, $calls, $go_listlocal, $go_cloudserver, $go_dedicated, $go_vps, $go_classic, $go_mywebsite, $go_email, $go_ebusiness, $go_marketing, $go_office, $go_domains, $go
                ];

                $breakdown['data'][] = [
                    $entry->name, $calls, $fo_listlocal, $fo_cloudserver, $fo_dedicated, $fo_vps, $fo_classic, $fo_mywebsite, $fo_email, $fo_ebusiness, $fo_marketing, $fo_office, $fo_domains, $fo
                ];

                $sastc['data'][] = [
                    $entry->name, $calls, $tc_listlocal, $tc_cloudserver, $tc_dedicated, $tc_vps, $tc_classic, $tc_mywebsite, $tc_email, $tc_ebusiness, $tc_marketing, $tc_office, $tc_domains, $sas
                ];
            }
        }

        $data['sastc'] = $sastc;
        $data['breakdown'] = $breakdown;
        $data['overview_table'] = $sas_table;
        $data['page_title'] = 'SAS Breakdown';
        $data['page_desc'] = 'Shows the SAS FO, GO, TC Breakdown for the Current Week.';
        $data['team_selection'] = $team_selection;
        $data['perfurl'] = 'sas';
        return view('perfmanagement.sasoverview', $data);
    }

    public function save_targets(Request $request) {
        $data = array(
            'logged_by' => Auth::user()->uid,
            'departmentid' => Auth::user()->departmentid,
            'month' => $request->get('month'),
            'year' => date("Y"),
            'target' => $request->get('target')
        );

        SASTargets::create($data);
        return redirect('sas/runningsas');
    }

    public function dashboard($wk = false) {
        $filter_list = [];
        $filter_selection = [];
        $name_selection = [];
        $entries = [];

        $dash_data = [
            'total' => 0, 'featured' => 0,
            'gross' => 0, 'tariff' => 0
        ];

        switch (Auth::user()->roles) {
            case 'SAS':
            case 'MANAGER':
            case 'SOM':
                $filter_selection = $this->teams->lists('name', 'departmentid')->sort();
                $filter_list = $this->exemptions;
                $entries = $this->teams->reject(function($value) {
                    return in_array($value->departmentid, $this->exemptions);
                });
                $name_selection = $entries->lists('name', 'departmentid')->sort();

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
                $filter_selection = $_entries->lists('lfname', 'uid')->sort();
                $filter_list = $this->exemptions;
                $entries = $_entries->reject(function($value) {
                    return in_array($value->uid, $this->exemptions);
                });
        }

        foreach ($entries as $entry) {
            $dash_data['featured'] += $entry->upsells()->weekly(6)->valid()->fo()->count();
            $dash_data['gross'] += $entry->upsells()->weekly(6)->valid()->go()->count();
            $dash_data['tariff'] += $entry->upsells()->weekly(6)->sastc()->count();
            $dash_data['total'] += $dash_data['featured'] + $dash_data['gross'] + $dash_data['tariff'];
        }

        $data['dash_data'] = $dash_data;
        $data['page_title'] = 'SAS Dashboard';
        $data['page_desc'] = 'Shows SAS overview for the current week.';
        $data['filter_selection'] = $filter_selection;
        $data['filter_list'] = $filter_list;
        $data['name_selection'] = $name_selection;
        $data['perfurl'] = 'sas';
        return view('perfmanagement.sasdashboard', $data);
    }

    public function weekly_sas(Request $request) {
        $stats = collect();
        $wk = $request->has('week_selection') ? $request->get('week_selection') : false;
        $entries = [];
        switch (Auth::user()->roles) {
            case 'SAS':
            case 'MANAGER':
            case 'SOM':
                if ($request->has('team_selection')) {
                    if ($request->get('team_selection') == 'all') {
                        $entries = $this->teams->reject(function($value) {
                            return in_array($value->departmentid, $this->exemptions);
                        });
                    } else {
                        $_t = \App\Department::where('departmentid', $request->get('team_selection'))->first();
                        $entries = $_t->members->get();
                        $entries->push($_t->head);
                    }
                } else
                    $entries = $this->teams;
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
        }

        foreach ($entries as $entry) {
            if ($request->has('date_start') && $request->has('date_end')) {
                $start = $request->get('date_start');
                $end = $request->get('date_end');

                $difm = $entry->upsells()->dateRange($start, $end)->valid()->difm()->count();
                $listlocal = $entry->upsells()->dateRange($start, $end)->valid()->listlocal()->count();
                $cloudserver = $entry->upsells()->dateRange($start, $end)->valid()->cloudserver()->count();
                $dedicated = $entry->upsells()->dateRange($start, $end)->valid()->dedicated()->count();
                $vps = $entry->upsells()->dateRange($start, $end)->valid()->vps()->count();
                $classic = $entry->upsells()->dateRange($start, $end)->valid()->classic()->count();
                $mywebsite = $entry->upsells()->dateRange($start, $end)->valid()->mywebsite()->count();
                $email = $entry->upsells()->dateRange($start, $end)->valid()->email()->count();
                $ebusiness = $entry->upsells()->dateRange($start, $end)->valid()->ebusiness()->count();
                $marketing = $entry->upsells()->dateRange($start, $end)->valid()->marketing()->count();
                $office = $entry->upsells()->dateRange($start, $end)->valid()->office()->count();
                $domains = $entry->upsells()->dateRange($start, $end)->valid()->domains()->count();
                $fo = $entry->upsells()->dateRange($start, $end)->valid()->fo()->count();
                $go = $entry->upsells()->dateRange($start, $end)->valid()->go()->count();
                $calls = $entry->cases()->calls()->dateRange($start, $end)->sum('case_count');
            } else {
                $difm = $entry->upsells()->weekly($wk)->valid()->difm()->count();
                $listlocal = $entry->upsells()->weekly($wk)->valid()->listlocal()->count();
                $cloudserver = $entry->upsells()->weekly($wk)->valid()->cloudserver()->count();
                $dedicated = $entry->upsells()->weekly($wk)->valid()->dedicated()->count();
                $vps = $entry->upsells()->weekly($wk)->valid()->vps()->count();
                $classic = $entry->upsells()->weekly($wk)->valid()->classic()->count();
                $mywebsite = $entry->upsells()->weekly($wk)->valid()->mywebsite()->count();
                $email = $entry->upsells()->weekly($wk)->valid()->email()->count();
                $ebusiness = $entry->upsells()->weekly($wk)->valid()->ebusiness()->count();
                $marketing = $entry->upsells()->weekly($wk)->valid()->marketing()->count();
                $office = $entry->upsells()->weekly($wk)->valid()->office()->count();
                $domains = $entry->upsells()->weekly($wk)->valid()->domains()->count();
                $fo = $entry->upsells()->weekly($wk)->valid()->fo()->count();
                $go = $entry->upsells()->weekly($wk)->valid()->go()->count();
                $calls = $entry->cases()->calls()->weekly($wk)->sum('case_count');
            }
            $all = $difm + $listlocal + $cloudserver + $dedicated + $vps + $classic + $mywebsite + $email + $ebusiness + $marketing + $office;
            $sales = $fo + $go;
            $cr = $sales == 0 ? 0 : round(($sales / $calls) * 100, 2);

            $rdata = [
                $request->get('team_selection') == 'all' ? $entry->name : $entry->lfname,
                $difm,
                $listlocal,
                $cloudserver,
                $dedicated,
                $vps,
                $classic,
                $mywebsite,
                $email,
                $ebusiness,
                $marketing,
                $office,
                $domains,
                $all,
                $go,
                $fo,
                $sales,
                $calls,
                $cr
            ];
            $stats->push($rdata);
        }
        return ['recordsTotal' => $stats->count(), 'recordsFiltered' => $stats->count(), 'data' => $stats];
    }

    public function running_sas(Request $request) {
        $sas_targets = new SASTargets();
        $wk = $request->has('w') ? $request->get('w') : false;
        $team_selection = [];

        $fo = 0;
        $go = 0;
        $sas_tc = 0;
        $calls = 0;
        $difm = 0;
        $listlocal = 0;
        $cloudserver = 0;
        $dedicated = 0;
        $vps = 0;
        $classic = 0;
        $mywebsite = 0;
        $email = 0;
        $ebusiness = 0;
        $marketing = 0;
        $office = 0;
        $domains = 0;
        $calls_handled = 0;
        $entries = [];

        switch (Auth::user()->roles) {
            case 'SAS':
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

        $sales = [
            'name' => 'Gross Order ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['', ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']', 'Weekly Target', 'Balance', '% Achieved', 'Call Handled', 'CR', 'SAS/Day'],
            'headerStyle' => ['w', '', '', '', '', '', '', ''],
            'data' => []
        ];

        foreach ($entries as $entry) {
            if ($request->has('date_start') && $request->has('date_end')) {
                $start = $request->get('date_start');
                $end = $request->get('date_end');
                $fo += $entry->upsells()->dateRange($start, $end)->valid()->fo()->count();
                $go += $entry->upsells()->dateRange($start, $end)->valid()->go()->count();
                $sas_tc += $entry->upsells()->dateRange($start, $end)->sastc()->count();
                $calls += $entry->cases()->calls()->dateRange($start, $end)->sum('case_count');
                $calls_handled += $entry->cosmocalls()->dateRange($start, $end)->sum('calls_handled');
                $difm += $entry->upsells()->dateRange($start, $end)->valid()->difm()->count();
                $listlocal += $entry->upsells()->dateRange($start, $end)->valid()->listlocal()->count();
                $cloudserver += $entry->upsells()->dateRange($start, $end)->valid()->cloudserver()->count();
                $dedicated += $entry->upsells()->dateRange($start, $end)->valid()->dedicated()->count();
                $vps += $entry->upsells()->dateRange($start, $end)->valid()->vps()->count();
                $classic += $entry->upsells()->dateRange($start, $end)->valid()->classic()->count();
                $mywebsite += $entry->upsells()->dateRange($start, $end)->valid()->mywebsite()->count();
                $email += $entry->upsells()->dateRange($start, $end)->valid()->email()->count();
                $ebusiness += $entry->upsells()->dateRange($start, $end)->valid()->ebusiness()->count();
                $marketing += $entry->upsells()->dateRange($start, $end)->valid()->marketing()->count();
                $office += $entry->upsells()->dateRange($start, $end)->valid()->office()->count();
                $domains += $entry->upsells()->dateRange($start, $end)->valid()->domains()->count();
            } else {
                $fo += $entry->upsells()->weekly($wk)->valid()->fo()->count();
                $go += $entry->upsells()->weekly($wk)->valid()->go()->count();
                $sas_tc += $entry->upsells()->weekly($wk)->sastc()->count();
                $calls += $entry->cases()->calls()->weekly($wk)->sum('case_count');
                $calls_handled += $entry->cosmocalls()->weekly($wk)->sum('calls_handled');
                $difm += $entry->upsells()->weekly($wk)->valid()->difm()->count();
                $listlocal += $entry->upsells()->weekly($wk)->valid()->listlocal()->count();
                $cloudserver += $entry->upsells()->weekly($wk)->valid()->cloudserver()->count();
                $dedicated += $entry->upsells()->weekly($wk)->valid()->dedicated()->count();
                $vps += $entry->upsells()->weekly($wk)->valid()->vps()->count();
                $classic += $entry->upsells()->weekly($wk)->valid()->classic()->count();
                $mywebsite += $entry->upsells()->weekly($wk)->valid()->mywebsite()->count();
                $email += $entry->upsells()->weekly($wk)->valid()->email()->count();
                $ebusiness += $entry->upsells()->weekly($wk)->valid()->ebusiness()->count();
                $marketing += $entry->upsells()->weekly($wk)->valid()->marketing()->count();
                $office += $entry->upsells()->weekly($wk)->valid()->office()->count();
                $domains += $entry->upsells()->weekly($wk)->valid()->domains()->count();
            }
        }

        $germany_view = $fo + $go + $sas_tc;
        $agent_view = $difm + $listlocal + $cloudserver + $dedicated + $vps + $classic + $mywebsite + $email + $ebusiness + $marketing + $office;
        $uk_view = $domains + $difm + $listlocal + $cloudserver + $dedicated + $vps + $classic + $mywebsite + $email + $ebusiness + $marketing + $office;

        $sales['data'][] = [
            'Germany View', $germany_view, '', '', '', $calls_handled, '', ''
        ];

        $sales['data'][] = [
            'Agent View', $agent_view, '', '', '', $calls_handled, '', ''
        ];

        $sales['data'][] = [
            'UK View', $uk_view, '', '', '', $calls_handled, '', ''
        ];

        $targets = $sas_targets->where('year', date('Y'))->get();


        $data['page_title'] = 'SAS Week on Week';
        $data['page_desc'] = 'Shows GO, FO, SAS MC, SAS TC data overview for the current week.';
        $data['team_selection'] = $team_selection;
        $data['perfurl'] = 'sas/runningsas';
        $data['targets'] = $targets;
        $data['overview'] = $sales;
        return view('perfmanagement.weekly', $data);
    }

    public function go_fo(Request $request) {
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

        $data['page_title'] = 'SAS FO vs. GO';
        $data['page_desc'] = 'Shows GO and FO data overview for the current week.';
        $data['team_selection'] = $team_selection;
        $data['perfurl'] = 'sas/gofo';
        $data['overview'] = $sales;
        $data['consolidated'] = $gofo;
        return view('perfmanagement.dataoverview', $data);
    }

    public function featured(Request $request) {
        $wk = $request->has('w') ? $request->get('w') : false;
        $team_selection = [];

        $sales = array(
            'data' => '',
            'name' => 'ListLocal',
            'yLabel' => 'ListLocal',
            'xLabel' => 'ListLocal Overview'
        );

        $difm = array(
            'data' => '',
            'name' => 'DIFM',
            'yLabel' => 'DIFM',
            'xLabel' => 'DIFM Overview'
        );

        $cloud = array(
            'data' => '',
            'name' => 'Cloud Server',
            'yLabel' => 'Cloud Server',
            'xLabel' => 'Cloud Server Overview'
        );

        $dedicated = array(
            'data' => '',
            'name' => 'Dedicated Server',
            'yLabel' => 'Dedicated Server',
            'xLabel' => 'Dedicated Server Overview'
        );

        $vps = array(
            'data' => '',
            'name' => 'VPS',
            'yLabel' => 'VPS',
            'xLabel' => 'VPS Overview'
        );

        $chosting = array(
            'data' => '',
            'name' => 'Classic Hosting',
            'yLabel' => 'Classic Hosting',
            'xLabel' => 'Classic Hosting Overview'
        );

        $mywebsite = array(
            'data' => '',
            'name' => 'MyWebsite',
            'yLabel' => 'MyWebsite',
            'xLabel' => 'MyWebsite Overview'
        );

        $email = array(
            'data' => '',
            'name' => 'E-mail',
            'yLabel' => 'E-mail',
            'xLabel' => 'E-mail Overview'
        );

        $ebusiness = array(
            'data' => '',
            'name' => 'E-Business',
            'yLabel' => 'E-Business',
            'xLabel' => 'E-Business Overview'
        );

        $marketing = array(
            'data' => '',
            'name' => 'Online Marketing',
            'yLabel' => 'Online Marketing',
            'xLabel' => 'Marketing Overview'
        );

        $office = array(
            'data' => '',
            'name' => 'Office',
            'yLabel' => 'Office',
            'xLabel' => 'Office Overview'
        );

        $domains = array(
            'data' => '',
            'name' => 'Domains',
            'yLabel' => 'Domains',
            'xLabel' => 'Domains Overview'
        );

        $entries = [];
        switch (Auth::user()->roles) {
            case 'SAS':
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
            'name' => 'ListLocal Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_difm = [
            'name' => 'ListLocal Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_cloud = [
            'name' => 'Cloud Server Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_dedicated = [
            'name' => 'Dedicated Server Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_vps = [
            'name' => 'VPS Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_chosting = [
            'name' => 'Classic Hosting Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_mywebsite = [
            'name' => 'MyWebsite Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_email = [
            'name' => 'E-mail Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_ebusiness = [
            'name' => 'E-Business Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_marketing = [
            'name' => 'Online Marketing Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_office = [
            'name' => 'Office Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_domain = [
            'name' => 'Domains Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $_sales = [];
        $_difm = [];
        $cloud_details = [];
        $_dedicated = [];
        $_vps = [];
        $_chosting = [];
        $_mywebsite = [];
        $_email = [];
        $_ebusiness = [];
        $_marketing = [];
        $_office = [];
        $_domain = [];

        foreach ($entries as $entry) {
            if ($request->has('date_start') && $request->has('date_end')) {
                $start = $request->get('date_start');
                $end = $request->get('date_end');
                $listlocal = $entry->upsells()->dateRange($start, $end)->valid()->fo()->listlocal()->count();
                $di_fm = $entry->upsells()->dateRange($start, $end)->valid()->fo()->difm()->count();
                $cloud_sales = $entry->upsells()->dateRange($start, $end)->valid()->fo()->cloudserver()->count();
                $_dedicated_detail = $entry->upsells()->dateRange($start, $end)->valid()->fo()->dedicated()->count();
                $vps_detail = $entry->upsells()->dateRange($start, $end)->valid()->fo()->vps()->count();
                $chosting_detail = $entry->upsells()->dateRange($start, $end)->valid()->fo()->classic()->count();
                $mywebsite_detail = $entry->upsells()->dateRange($start, $end)->valid()->fo()->mywebsite()->count();
                $email_detail = $entry->upsells()->dateRange($start, $end)->valid()->fo()->email()->count();
                $ebusiness_detail = $entry->upsells()->dateRange($start, $end)->valid()->fo()->ebusiness()->count();
                $marketing_detail = $entry->upsells()->dateRange($start, $end)->valid()->fo()->marketing()->count();
                $office_detail = $entry->upsells()->dateRange($start, $end)->valid()->fo()->office()->count();
                $domain_detail = $entry->upsells()->dateRange($start, $end)->valid()->fo()->domains()->count();
            } else {
                $listlocal = $entry->upsells()->weekly($wk)->valid()->fo()->listlocal()->count();
                $di_fm = $entry->upsells()->weekly($wk)->valid()->fo()->difm()->count();
                $cloud_sales = $entry->upsells()->weekly($wk)->valid()->fo()->cloudserver()->count();
                $_dedicated_detail = $entry->upsells()->weekly($wk)->valid()->fo()->dedicated()->count();
                $vps_detail = $entry->upsells()->weekly($wk)->valid()->fo()->vps()->count();
                $chosting_detail = $entry->upsells()->weekly($wk)->valid()->fo()->classic()->count();
                $mywebsite_detail = $entry->upsells()->weekly($wk)->valid()->fo()->mywebsite()->count();
                $email_detail = $entry->upsells()->weekly($wk)->valid()->fo()->email()->count();
                $ebusiness_detail = $entry->upsells()->weekly($wk)->valid()->fo()->ebusiness()->count();
                $marketing_detail = $entry->upsells()->weekly($wk)->valid()->fo()->marketing()->count();
                $office_detail = $entry->upsells()->weekly($wk)->valid()->fo()->office()->count();
                $domain_detail = $entry->upsells()->weekly($wk)->valid()->fo()->domains()->count();
            }

            $_sales[] = [
                'total' => $listlocal,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_difm[] = [
                'total' => $di_fm,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $cloud_details[] = [
                'total' => $cloud_sales,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_dedicated[] = [
                'total' => $_dedicated_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_vps[] = [
                'total' => $vps_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_chosting[] = [
                'total' => $chosting_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_mywebsite[] = [
                'total' => $mywebsite_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_email[] = [
                'total' => $email_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_ebusiness[] = [
                'total' => $ebusiness_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_marketing[] = [
                'total' => $marketing_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_office[] = [
                'total' => $office_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_domain[] = [
                'total' => $domain_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            if ($request->has('date_start') && $request->has('date_end')) {
                $sas = $entry->upsells()->dateRange($start, $end)->valid()->fo()->listlocal();
                $sas_difm = $entry->upsells()->dateRange($start, $end)->valid()->fo()->difm();
                $sas_cloud = $entry->upsells()->dateRange($start, $end)->valid()->fo()->cloudserver();
                $sas_dedicated = $entry->upsells()->dateRange($start, $end)->valid()->fo()->dedicated();
                $sas_vps = $entry->upsells()->dateRange($start, $end)->valid()->fo()->vps();
                $sas_chosting = $entry->upsells()->dateRange($start, $end)->valid()->fo()->classic();
                $sas_mywebsite = $entry->upsells()->dateRange($start, $end)->valid()->fo()->mywebsite();
                $sas_email = $entry->upsells()->dateRange($start, $end)->valid()->fo()->email();
                $sas_ebusiness = $entry->upsells()->dateRange($start, $end)->valid()->fo()->ebusiness();
                $sas_marketing = $entry->upsells()->dateRange($start, $end)->valid()->fo()->marketing();
                $sas_office = $entry->upsells()->dateRange($start, $end)->valid()->fo()->office();
                $sas_domain = $entry->upsells()->dateRange($start, $end)->valid()->fo()->domains();
            } else {
                $sas = $entry->upsells()->weekly($wk)->valid()->fo()->listlocal();
                $sas_difm = $entry->upsells()->weekly($wk)->valid()->fo()->difm();
                $sas_cloud = $entry->upsells()->weekly($wk)->valid()->fo()->cloudserver();
                $sas_dedicated = $entry->upsells()->weekly($wk)->valid()->fo()->dedicated();
                $sas_vps = $entry->upsells()->weekly($wk)->valid()->fo()->vps();
                $sas_chosting = $entry->upsells()->weekly($wk)->valid()->fo()->classic();
                $sas_mywebsite = $entry->upsells()->weekly($wk)->valid()->fo()->mywebsite();
                $sas_email = $entry->upsells()->weekly($wk)->valid()->fo()->email();
                $sas_ebusiness = $entry->upsells()->weekly($wk)->valid()->fo()->ebusiness();
                $sas_marketing = $entry->upsells()->weekly($wk)->valid()->fo()->marketing();
                $sas_office = $entry->upsells()->weekly($wk)->valid()->fo()->office();
                $sas_domain = $entry->upsells()->weekly($wk)->valid()->fo()->domains();
            }

            if (Auth::user()->roles != 'AGENT') {
                foreach ($sas->get() as $_sas) {
                    $breakdown['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_difm->get() as $_sast) {
                    $breakdown_difm['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_cloud->get() as $_sas) {
                    $breakdown_cloud['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_dedicated->get() as $_sas) {
                    $breakdown_dedicated['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_vps->get() as $_sas) {
                    $breakdown_vps['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_chosting->get() as $_sas) {
                    $breakdown_chosting['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_mywebsite->get() as $_sas) {
                    $breakdown_mywebsite['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_email->get() as $_sas) {
                    $breakdown_email['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_ebusiness->get() as $_sas) {
                    $breakdown_ebusiness['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_marketing->get() as $_sas) {
                    $breakdown_marketing['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_office->get() as $_sas) {
                    $breakdown_office['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_domain->get() as $_sas) {
                    $breakdown_domain['data'][] = [
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

                    foreach ($sas_difm->get() as $_sas) {
                        $breakdown_difm['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_cloud->get() as $_sas) {
                        $breakdown_cloud['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_dedicated->get() as $_sas) {
                        $breakdown_dedicated['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_vps->get() as $_sas) {
                        $breakdown_vps['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_chosting->get() as $_sas) {
                        $breakdown_chosting['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_mywebsite->get() as $_sas) {
                        $breakdown_mywebsite['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_email->get() as $_sas) {
                        $breakdown_email['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_ebusiness->get() as $_sas) {
                        $breakdown_ebusiness['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_marketing->get() as $_sas) {
                        $breakdown_marketing['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_office->get() as $_sas) {
                        $breakdown_office['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_domain->get() as $_sas) {
                        $breakdown_domain['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }
                }
            }
        }

        rsort($_sales);
        $sales['data'] = $_sales;

        rsort($_difm);
        $difm['data'] = $_difm;

        rsort($cloud_details);
        $cloud['data'] = $cloud_details;

        rsort($_dedicated);
        $dedicated['data'] = $_dedicated;

        rsort($_vps);
        $vps['data'] = $_vps;

        rsort($_chosting);
        $chosting['data'] = $_chosting;

        rsort($_mywebsite);
        $mywebsite['data'] = $_mywebsite;

        rsort($_email);
        $email['data'] = $_email;

        rsort($_ebusiness);
        $ebusiness['data'] = $_ebusiness;

        rsort($_marketing);
        $marketing['data'] = $_marketing;

        rsort($_office);
        $office['data'] = $_office;

        rsort($_domain);
        $domains['data'] = $_domain;

        $data['breakdown'] = $breakdown;
        $data['breakdown_difm'] = $breakdown_difm;
        $data['breakdown_cloud'] = $breakdown_cloud;
        $data['breakdown_dedicated'] = $breakdown_dedicated;
        $data['breakdown_vps'] = $breakdown_vps;
        $data['breakdown_chosting'] = $breakdown_chosting;
        $data['breakdown_mywebsite'] = $breakdown_mywebsite;
        $data['breakdown_email'] = $breakdown_email;
        $data['breakdown_ebusiness'] = $breakdown_ebusiness;
        $data['breakdown_marketing'] = $breakdown_marketing;
        $data['breakdown_office'] = $breakdown_office;
        $data['breakdown_domain'] = $breakdown_domain;
        $data['page_title'] = 'SAS Featured Products';
        $data['page_desc'] = 'Shows all featured products overview for the current week.';
        $data['team_selection'] = $team_selection;
        $data['perfurl'] = 'sas/featured';

        $data['overview'] = $sales;
        $data['overview_difm'] = $difm;
        $data['overview_cloud'] = $cloud;
        $data['overview_dedicated'] = $dedicated;
        $data['overview_vps'] = $vps;
        $data['overview_chosting'] = $chosting;
        $data['overview_mywebsite'] = $mywebsite;
        $data['overview_email'] = $email;
        $data['overview_ebusiness'] = $ebusiness;
        $data['overview_marketing'] = $marketing;
        $data['overview_office'] = $office;
        $data['overview_domain'] = $domains;
        return view('perfmanagement.products', $data);
    }

    public function gross(Request $request) {
        $wk = $request->has('w') ? $request->get('w') : false;
        $team_selection = [];

        $sales = array(
            'data' => '',
            'name' => 'ListLocal',
            'yLabel' => 'ListLocal',
            'xLabel' => 'ListLocal Overview'
        );

        $difm = array(
            'data' => '',
            'name' => 'DIFM',
            'yLabel' => 'DIFM',
            'xLabel' => 'DIFM Overview'
        );

        $cloud = array(
            'data' => '',
            'name' => 'Cloud Server',
            'yLabel' => 'Cloud Server',
            'xLabel' => 'Cloud Server Overview'
        );

        $dedicated = array(
            'data' => '',
            'name' => 'Dedicated Server',
            'yLabel' => 'Dedicated Server',
            'xLabel' => 'Dedicated Server Overview'
        );

        $vps = array(
            'data' => '',
            'name' => 'VPS',
            'yLabel' => 'VPS',
            'xLabel' => 'VPS Overview'
        );

        $chosting = array(
            'data' => '',
            'name' => 'Classic Hosting',
            'yLabel' => 'Classic Hosting',
            'xLabel' => 'Classic Hosting Overview'
        );

        $mywebsite = array(
            'data' => '',
            'name' => 'MyWebsite',
            'yLabel' => 'MyWebsite',
            'xLabel' => 'MyWebsite Overview'
        );

        $email = array(
            'data' => '',
            'name' => 'E-mail',
            'yLabel' => 'E-mail',
            'xLabel' => 'E-mail Overview'
        );

        $ebusiness = array(
            'data' => '',
            'name' => 'E-Business',
            'yLabel' => 'E-Business',
            'xLabel' => 'E-Business Overview'
        );

        $marketing = array(
            'data' => '',
            'name' => 'Online Marketing',
            'yLabel' => 'Online Marketing',
            'xLabel' => 'Marketing Overview'
        );

        $office = array(
            'data' => '',
            'name' => 'Office',
            'yLabel' => 'Office',
            'xLabel' => 'Office Overview'
        );

        $domains = array(
            'data' => '',
            'name' => 'Domains',
            'yLabel' => 'Domains',
            'xLabel' => 'Domains Overview'
        );

        $entries = [];
        switch (Auth::user()->roles) {
            case 'SAS':
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
            'name' => 'ListLocal Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_difm = [
            'name' => 'ListLocal Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_cloud = [
            'name' => 'Cloud Server Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_dedicated = [
            'name' => 'Dedicated Server Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_vps = [
            'name' => 'VPS Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_chosting = [
            'name' => 'Classic Hosting Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_mywebsite = [
            'name' => 'MyWebsite Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_email = [
            'name' => 'E-mail Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_ebusiness = [
            'name' => 'E-Business Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_marketing = [
            'name' => 'Online Marketing Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_office = [
            'name' => 'Office Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_domain = [
            'name' => 'Domains Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $_sales = [];
        $_difm = [];
        $cloud_details = [];
        $_dedicated = [];
        $_vps = [];
        $_chosting = [];
        $_mywebsite = [];
        $_email = [];
        $_ebusiness = [];
        $_marketing = [];
        $_office = [];
        $_domain = [];

        foreach ($entries as $entry) {
            if ($request->has('date_start') && $request->has('date_end')) {
                $start = $request->get('date_start');
                $end = $request->get('date_end');
                $listlocal = $entry->upsells()->dateRange($start, $end)->valid()->go()->listlocal()->count();
                $di_fm = $entry->upsells()->dateRange($start, $end)->valid()->go()->difm()->count();
                $cloud_sales = $entry->upsells()->dateRange($start, $end)->valid()->go()->cloudserver()->count();
                $_dedicated_detail = $entry->upsells()->dateRange($start, $end)->valid()->go()->dedicated()->count();
                $vps_detail = $entry->upsells()->dateRange($start, $end)->valid()->go()->vps()->count();
                $chosting_detail = $entry->upsells()->dateRange($start, $end)->valid()->go()->classic()->count();
                $mywebsite_detail = $entry->upsells()->dateRange($start, $end)->valid()->go()->mywebsite()->count();
                $email_detail = $entry->upsells()->dateRange($start, $end)->valid()->go()->email()->count();
                $ebusiness_detail = $entry->upsells()->dateRange($start, $end)->valid()->go()->ebusiness()->count();
                $marketing_detail = $entry->upsells()->dateRange($start, $end)->valid()->go()->marketing()->count();
                $office_detail = $entry->upsells()->dateRange($start, $end)->valid()->go()->office()->count();
                $domain_detail = $entry->upsells()->dateRange($start, $end)->valid()->go()->domains()->count();
            } else {
                $listlocal = $entry->upsells()->weekly($wk)->valid()->go()->listlocal()->count();
                $di_fm = $entry->upsells()->weekly($wk)->valid()->go()->difm()->count();
                $cloud_sales = $entry->upsells()->weekly($wk)->valid()->go()->cloudserver()->count();
                $_dedicated_detail = $entry->upsells()->weekly($wk)->valid()->go()->dedicated()->count();
                $vps_detail = $entry->upsells()->weekly($wk)->valid()->go()->vps()->count();
                $chosting_detail = $entry->upsells()->weekly($wk)->valid()->go()->classic()->count();
                $mywebsite_detail = $entry->upsells()->weekly($wk)->valid()->go()->mywebsite()->count();
                $email_detail = $entry->upsells()->weekly($wk)->valid()->go()->email()->count();
                $ebusiness_detail = $entry->upsells()->weekly($wk)->valid()->go()->ebusiness()->count();
                $marketing_detail = $entry->upsells()->weekly($wk)->valid()->go()->marketing()->count();
                $office_detail = $entry->upsells()->weekly($wk)->valid()->go()->office()->count();
                $domain_detail = $entry->upsells()->weekly($wk)->valid()->go()->domains()->count();
            }

            $_sales[] = [
                'total' => $listlocal,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_difm[] = [
                'total' => $di_fm,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $cloud_details[] = [
                'total' => $cloud_sales,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_dedicated[] = [
                'total' => $_dedicated_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_vps[] = [
                'total' => $vps_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_chosting[] = [
                'total' => $chosting_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_mywebsite[] = [
                'total' => $mywebsite_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_email[] = [
                'total' => $email_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_ebusiness[] = [
                'total' => $ebusiness_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_marketing[] = [
                'total' => $marketing_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_office[] = [
                'total' => $office_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_domain[] = [
                'total' => $domain_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            if ($request->has('date_start') && $request->has('date_end')) {
                $sas = $entry->upsells()->dateRange($start, $end)->valid()->go()->listlocal();
                $sas_difm = $entry->upsells()->dateRange($start, $end)->valid()->go()->difm();
                $sas_cloud = $entry->upsells()->dateRange($start, $end)->valid()->go()->cloudserver();
                $sas_dedicated = $entry->upsells()->dateRange($start, $end)->valid()->go()->dedicated();
                $sas_vps = $entry->upsells()->dateRange($start, $end)->valid()->go()->vps();
                $sas_chosting = $entry->upsells()->dateRange($start, $end)->valid()->go()->classic();
                $sas_mywebsite = $entry->upsells()->dateRange($start, $end)->valid()->go()->mywebsite();
                $sas_email = $entry->upsells()->dateRange($start, $end)->valid()->go()->email();
                $sas_ebusiness = $entry->upsells()->dateRange($start, $end)->valid()->go()->ebusiness();
                $sas_marketing = $entry->upsells()->dateRange($start, $end)->valid()->go()->marketing();
                $sas_office = $entry->upsells()->dateRange($start, $end)->valid()->go()->office();
                $sas_domain = $entry->upsells()->dateRange($start, $end)->valid()->go()->domains();
            } else {
                $sas = $entry->upsells()->weekly($wk)->valid()->go()->listlocal();
                $sas_difm = $entry->upsells()->weekly($wk)->valid()->go()->difm();
                $sas_cloud = $entry->upsells()->weekly($wk)->valid()->go()->cloudserver();
                $sas_dedicated = $entry->upsells()->weekly($wk)->valid()->go()->dedicated();
                $sas_vps = $entry->upsells()->weekly($wk)->valid()->go()->vps();
                $sas_chosting = $entry->upsells()->weekly($wk)->valid()->go()->classic();
                $sas_mywebsite = $entry->upsells()->weekly($wk)->valid()->go()->mywebsite();
                $sas_email = $entry->upsells()->weekly($wk)->valid()->go()->email();
                $sas_ebusiness = $entry->upsells()->weekly($wk)->valid()->go()->ebusiness();
                $sas_marketing = $entry->upsells()->weekly($wk)->valid()->go()->marketing();
                $sas_office = $entry->upsells()->weekly($wk)->valid()->go()->office();
                $sas_domain = $entry->upsells()->weekly($wk)->valid()->go()->domains();
            }

            if (Auth::user()->roles != 'AGENT') {
                foreach ($sas->get() as $_sas) {
                    $breakdown['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_difm->get() as $_sast) {
                    $breakdown_difm['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_cloud->get() as $_sas) {
                    $breakdown_cloud['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_dedicated->get() as $_sas) {
                    $breakdown_dedicated['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_vps->get() as $_sas) {
                    $breakdown_vps['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_chosting->get() as $_sas) {
                    $breakdown_chosting['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_mywebsite->get() as $_sas) {
                    $breakdown_mywebsite['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_email->get() as $_sas) {
                    $breakdown_email['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_ebusiness->get() as $_sas) {
                    $breakdown_ebusiness['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_marketing->get() as $_sas) {
                    $breakdown_marketing['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_office->get() as $_sas) {
                    $breakdown_office['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_domain->get() as $_sas) {
                    $breakdown_domain['data'][] = [
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

                    foreach ($sas_difm->get() as $_sas) {
                        $breakdown_difm['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_cloud->get() as $_sas) {
                        $breakdown_cloud['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_dedicated->get() as $_sas) {
                        $breakdown_dedicated['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_vps->get() as $_sas) {
                        $breakdown_vps['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_chosting->get() as $_sas) {
                        $breakdown_chosting['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_mywebsite->get() as $_sas) {
                        $breakdown_mywebsite['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_email->get() as $_sas) {
                        $breakdown_email['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_ebusiness->get() as $_sas) {
                        $breakdown_ebusiness['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_marketing->get() as $_sas) {
                        $breakdown_marketing['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_office->get() as $_sas) {
                        $breakdown_office['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_domain->get() as $_sas) {
                        $breakdown_domain['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }
                }
            }
        }

        rsort($_sales);
        $sales['data'] = $_sales;

        rsort($_difm);
        $difm['data'] = $_difm;

        rsort($cloud_details);
        $cloud['data'] = $cloud_details;

        rsort($_dedicated);
        $dedicated['data'] = $_dedicated;

        rsort($_vps);
        $vps['data'] = $_vps;

        rsort($_chosting);
        $chosting['data'] = $_chosting;

        rsort($_mywebsite);
        $mywebsite['data'] = $_mywebsite;

        rsort($_email);
        $email['data'] = $_email;

        rsort($_ebusiness);
        $ebusiness['data'] = $_ebusiness;

        rsort($_marketing);
        $marketing['data'] = $_marketing;

        rsort($_office);
        $office['data'] = $_office;

        rsort($_domain);
        $domains['data'] = $_domain;

        $data['breakdown'] = $breakdown;
        $data['breakdown_difm'] = $breakdown_difm;
        $data['breakdown_cloud'] = $breakdown_cloud;
        $data['breakdown_dedicated'] = $breakdown_dedicated;
        $data['breakdown_vps'] = $breakdown_vps;
        $data['breakdown_chosting'] = $breakdown_chosting;
        $data['breakdown_mywebsite'] = $breakdown_mywebsite;
        $data['breakdown_email'] = $breakdown_email;
        $data['breakdown_ebusiness'] = $breakdown_ebusiness;
        $data['breakdown_marketing'] = $breakdown_marketing;
        $data['breakdown_office'] = $breakdown_office;
        $data['breakdown_domain'] = $breakdown_domain;
        $data['page_title'] = 'SAS Gross Products';
        $data['page_desc'] = 'Shows all Gross products overview for the current week.';
        $data['team_selection'] = $team_selection;
        $data['perfurl'] = 'sas/gross';

        $data['overview'] = $sales;
        $data['overview_difm'] = $difm;
        $data['overview_cloud'] = $cloud;
        $data['overview_dedicated'] = $dedicated;
        $data['overview_vps'] = $vps;
        $data['overview_chosting'] = $chosting;
        $data['overview_mywebsite'] = $mywebsite;
        $data['overview_email'] = $email;
        $data['overview_ebusiness'] = $ebusiness;
        $data['overview_marketing'] = $marketing;
        $data['overview_office'] = $office;
        $data['overview_domain'] = $domains;
        return view('perfmanagement.products', $data);
    }

    public function tariff(Request $request) {
        $wk = $request->has('w') ? $request->get('w') : false;
        $team_selection = [];

        $sales = array(
            'data' => '',
            'name' => 'ListLocal',
            'yLabel' => 'ListLocal',
            'xLabel' => 'ListLocal Overview'
        );

        $difm = array(
            'data' => '',
            'name' => 'DIFM',
            'yLabel' => 'DIFM',
            'xLabel' => 'DIFM Overview'
        );

        $cloud = array(
            'data' => '',
            'name' => 'Cloud Server',
            'yLabel' => 'Cloud Server',
            'xLabel' => 'Cloud Server Overview'
        );

        $dedicated = array(
            'data' => '',
            'name' => 'Dedicated Server',
            'yLabel' => 'Dedicated Server',
            'xLabel' => 'Dedicated Server Overview'
        );

        $vps = array(
            'data' => '',
            'name' => 'VPS',
            'yLabel' => 'VPS',
            'xLabel' => 'VPS Overview'
        );

        $chosting = array(
            'data' => '',
            'name' => 'Classic Hosting',
            'yLabel' => 'Classic Hosting',
            'xLabel' => 'Classic Hosting Overview'
        );

        $mywebsite = array(
            'data' => '',
            'name' => 'MyWebsite',
            'yLabel' => 'MyWebsite',
            'xLabel' => 'MyWebsite Overview'
        );

        $email = array(
            'data' => '',
            'name' => 'E-mail',
            'yLabel' => 'E-mail',
            'xLabel' => 'E-mail Overview'
        );

        $ebusiness = array(
            'data' => '',
            'name' => 'E-Business',
            'yLabel' => 'E-Business',
            'xLabel' => 'E-Business Overview'
        );

        $marketing = array(
            'data' => '',
            'name' => 'Online Marketing',
            'yLabel' => 'Online Marketing',
            'xLabel' => 'Marketing Overview'
        );

        $office = array(
            'data' => '',
            'name' => 'Office',
            'yLabel' => 'Office',
            'xLabel' => 'Office Overview'
        );

        $domains = array(
            'data' => '',
            'name' => 'Domains',
            'yLabel' => 'Domains',
            'xLabel' => 'Domains Overview'
        );

        $entries = [];
        switch (Auth::user()->roles) {
            case 'SAS':
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
            'name' => 'ListLocal Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_difm = [
            'name' => 'ListLocal Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_cloud = [
            'name' => 'Cloud Server Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_dedicated = [
            'name' => 'Dedicated Server Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_vps = [
            'name' => 'VPS Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_chosting = [
            'name' => 'Classic Hosting Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_mywebsite = [
            'name' => 'MyWebsite Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_email = [
            'name' => 'E-mail Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_ebusiness = [
            'name' => 'E-Business Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_marketing = [
            'name' => 'Online Marketing Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_office = [
            'name' => 'Office Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $breakdown_domain = [
            'name' => 'Domains Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Date', 'Contract ID', 'Customer ID', 'Employee', 'Product Desc', 'Transaction', 'Sales Cluster', 'Sales Cluster Compact', 'Transaction'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        $_sales = [];
        $_difm = [];
        $cloud_details = [];
        $_dedicated = [];
        $_vps = [];
        $_chosting = [];
        $_mywebsite = [];
        $_email = [];
        $_ebusiness = [];
        $_marketing = [];
        $_office = [];
        $_domain = [];

        foreach ($entries as $entry) {
            if ($request->has('date_start') && $request->has('date_end')) {
                $start = $request->get('date_start');
                $end = $request->get('date_end');
                $listlocal = $entry->upsells()->dateRange($start, $end)->sastc()->listlocal()->count();
                $di_fm = $entry->upsells()->dateRange($start, $end)->sastc()->difm()->count();
                $cloud_sales = $entry->upsells()->dateRange($start, $end)->sastc()->cloudserver()->count();
                $_dedicated_detail = $entry->upsells()->dateRange($start, $end)->sastc()->dedicated()->count();
                $vps_detail = $entry->upsells()->dateRange($start, $end)->sastc()->vps()->count();
                $chosting_detail = $entry->upsells()->dateRange($start, $end)->sastc()->classic()->count();
                $mywebsite_detail = $entry->upsells()->dateRange($start, $end)->sastc()->mywebsite()->count();
                $email_detail = $entry->upsells()->dateRange($start, $end)->sastc()->email()->count();
                $ebusiness_detail = $entry->upsells()->dateRange($start, $end)->sastc()->ebusiness()->count();
                $marketing_detail = $entry->upsells()->dateRange($start, $end)->sastc()->marketing()->count();
                $office_detail = $entry->upsells()->dateRange($start, $end)->sastc()->office()->count();
                $domain_detail = $entry->upsells()->dateRange($start, $end)->sastc()->domains()->count();
            } else {
                $listlocal = $entry->upsells()->weekly($wk)->sastc()->listlocal()->count();
                $di_fm = $entry->upsells()->weekly($wk)->sastc()->difm()->count();
                $cloud_sales = $entry->upsells()->weekly($wk)->sastc()->cloudserver()->count();
                $_dedicated_detail = $entry->upsells()->weekly($wk)->sastc()->dedicated()->count();
                $vps_detail = $entry->upsells()->weekly($wk)->sastc()->vps()->count();
                $chosting_detail = $entry->upsells()->weekly($wk)->sastc()->classic()->count();
                $mywebsite_detail = $entry->upsells()->weekly($wk)->sastc()->mywebsite()->count();
                $email_detail = $entry->upsells()->weekly($wk)->sastc()->email()->count();
                $ebusiness_detail = $entry->upsells()->weekly($wk)->sastc()->ebusiness()->count();
                $marketing_detail = $entry->upsells()->weekly($wk)->sastc()->marketing()->count();
                $office_detail = $entry->upsells()->weekly($wk)->sastc()->office()->count();
                $domain_detail = $entry->upsells()->weekly($wk)->sastc()->domains()->count();
            }

            $_sales[] = [
                'total' => $listlocal,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_difm[] = [
                'total' => $di_fm,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $cloud_details[] = [
                'total' => $cloud_sales,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_dedicated[] = [
                'total' => $_dedicated_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_vps[] = [
                'total' => $vps_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_chosting[] = [
                'total' => $chosting_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_mywebsite[] = [
                'total' => $mywebsite_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_email[] = [
                'total' => $email_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_ebusiness[] = [
                'total' => $ebusiness_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_marketing[] = [
                'total' => $marketing_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_office[] = [
                'total' => $office_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            $_domain[] = [
                'total' => $domain_detail,
                'label' => $entry instanceof \App\Department ? $entry->shortName : $entry->lname,
                'deptid' => $entry instanceof \App\Department ? $entry->departmentid : 0
            ];

            if ($request->has('date_start') && $request->has('date_end')) {
                $sas = $entry->upsells()->dateRange($start, $end)->sastc()->listlocal();
                $sas_difm = $entry->upsells()->dateRange($start, $end)->sastc()->difm();
                $sas_cloud = $entry->upsells()->dateRange($start, $end)->sastc()->cloudserver();
                $sas_dedicated = $entry->upsells()->dateRange($start, $end)->sastc()->dedicated();
                $sas_vps = $entry->upsells()->dateRange($start, $end)->sastc()->vps();
                $sas_chosting = $entry->upsells()->dateRange($start, $end)->sastc()->classic();
                $sas_mywebsite = $entry->upsells()->dateRange($start, $end)->sastc()->mywebsite();
                $sas_email = $entry->upsells()->dateRange($start, $end)->sastc()->email();
                $sas_ebusiness = $entry->upsells()->dateRange($start, $end)->sastc()->ebusiness();
                $sas_marketing = $entry->upsells()->dateRange($start, $end)->sastc()->marketing();
                $sas_office = $entry->upsells()->dateRange($start, $end)->sastc()->office();
                $sas_domain = $entry->upsells()->dateRange($start, $end)->sastc()->domains();
            } else {
                $sas = $entry->upsells()->weekly($wk)->sastc()->listlocal();
                $sas_difm = $entry->upsells()->weekly($wk)->sastc()->difm();
                $sas_cloud = $entry->upsells()->weekly($wk)->sastc()->cloudserver();
                $sas_dedicated = $entry->upsells()->weekly($wk)->sastc()->dedicated();
                $sas_vps = $entry->upsells()->weekly($wk)->sastc()->vps();
                $sas_chosting = $entry->upsells()->weekly($wk)->sastc()->classic();
                $sas_mywebsite = $entry->upsells()->weekly($wk)->sastc()->mywebsite();
                $sas_email = $entry->upsells()->weekly($wk)->sastc()->email();
                $sas_ebusiness = $entry->upsells()->weekly($wk)->sastc()->ebusiness();
                $sas_marketing = $entry->upsells()->weekly($wk)->sastc()->marketing();
                $sas_office = $entry->upsells()->weekly($wk)->sastc()->office();
                $sas_domain = $entry->upsells()->weekly($wk)->sastc()->domains();
            }

            if (Auth::user()->roles != 'AGENT') {
                foreach ($sas->get() as $_sas) {
                    $breakdown['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_difm->get() as $_sast) {
                    $breakdown_difm['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_cloud->get() as $_sas) {
                    $breakdown_cloud['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_dedicated->get() as $_sas) {
                    $breakdown_dedicated['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_vps->get() as $_sas) {
                    $breakdown_vps['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_chosting->get() as $_sas) {
                    $breakdown_chosting['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_mywebsite->get() as $_sas) {
                    $breakdown_mywebsite['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_email->get() as $_sas) {
                    $breakdown_email['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_ebusiness->get() as $_sas) {
                    $breakdown_ebusiness['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_marketing->get() as $_sas) {
                    $breakdown_marketing['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_office->get() as $_sas) {
                    $breakdown_office['data'][] = [
                        $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                        $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                    ];
                }

                foreach ($sas_domain->get() as $_sas) {
                    $breakdown_domain['data'][] = [
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

                    foreach ($sas_difm->get() as $_sas) {
                        $breakdown_difm['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_cloud->get() as $_sas) {
                        $breakdown_cloud['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_dedicated->get() as $_sas) {
                        $breakdown_dedicated['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_vps->get() as $_sas) {
                        $breakdown_vps['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_chosting->get() as $_sas) {
                        $breakdown_chosting['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_mywebsite->get() as $_sas) {
                        $breakdown_mywebsite['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_email->get() as $_sas) {
                        $breakdown_email['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_ebusiness->get() as $_sas) {
                        $breakdown_ebusiness['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_marketing->get() as $_sas) {
                        $breakdown_marketing['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_office->get() as $_sas) {
                        $breakdown_office['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }

                    foreach ($sas_domain->get() as $_sas) {
                        $breakdown_domain['data'][] = [
                            $_sas->sales_date, $_sas->contract_id, $_sas->customer_id, $_sas->firstname . ' ' . $_sas->lastname, $_sas->product_desc, $_sas->mc_check,
                            $_sas->ops_sales_cluster, $_sas->ops_sales_cluster_compact, $_sas->transaction
                        ];
                    }
                }
            }
        }

        rsort($_sales);
        $sales['data'] = $_sales;

        rsort($_difm);
        $difm['data'] = $_difm;

        rsort($cloud_details);
        $cloud['data'] = $cloud_details;

        rsort($_dedicated);
        $dedicated['data'] = $_dedicated;

        rsort($_vps);
        $vps['data'] = $_vps;

        rsort($_chosting);
        $chosting['data'] = $_chosting;

        rsort($_mywebsite);
        $mywebsite['data'] = $_mywebsite;

        rsort($_email);
        $email['data'] = $_email;

        rsort($_ebusiness);
        $ebusiness['data'] = $_ebusiness;

        rsort($_marketing);
        $marketing['data'] = $_marketing;

        rsort($_office);
        $office['data'] = $_office;

        rsort($_domain);
        $domains['data'] = $_domain;

        $data['breakdown'] = $breakdown;
        $data['breakdown_difm'] = $breakdown_difm;
        $data['breakdown_cloud'] = $breakdown_cloud;
        $data['breakdown_dedicated'] = $breakdown_dedicated;
        $data['breakdown_vps'] = $breakdown_vps;
        $data['breakdown_chosting'] = $breakdown_chosting;
        $data['breakdown_mywebsite'] = $breakdown_mywebsite;
        $data['breakdown_email'] = $breakdown_email;
        $data['breakdown_ebusiness'] = $breakdown_ebusiness;
        $data['breakdown_marketing'] = $breakdown_marketing;
        $data['breakdown_office'] = $breakdown_office;
        $data['breakdown_domain'] = $breakdown_domain;
        $data['page_title'] = 'SAS Tariff Change';
        $data['page_desc'] = 'Shows all Tariff Change overview for the current week.';
        $data['team_selection'] = $team_selection;
        $data['perfurl'] = 'sas/tariff';

        $data['overview'] = $sales;
        $data['overview_difm'] = $difm;
        $data['overview_cloud'] = $cloud;
        $data['overview_dedicated'] = $dedicated;
        $data['overview_vps'] = $vps;
        $data['overview_chosting'] = $chosting;
        $data['overview_mywebsite'] = $mywebsite;
        $data['overview_email'] = $email;
        $data['overview_ebusiness'] = $ebusiness;
        $data['overview_marketing'] = $marketing;
        $data['overview_office'] = $office;
        $data['overview_domain'] = $domains;
        return view('perfmanagement.products', $data);
    }

    public function sas_reports() {
        $entries = \App\Department::where('name', 'like', '%UK Web Hosting %')->get();
        $team_selection = $entries->lists('name', 'departmentid')->sort();

        $data['page_title'] = 'SAS Generate Reports';
        $data['page_desc'] = 'Shows GO, FO, SAS MC, SAS TC data overview for the current week.';
        $data['team_selection'] = $team_selection;
        $data['perfurl'] = 'sas/domains';
        return view('perfmanagement.generatedreports', $data);
    }

    public function sas_generate(Request $request) {
        $wk = $request->has('w') ? $request->get('w') : false;
        $start = $request->get('date_from');
        $end = $request->get('date_to');
        $type = $request->get('type');
        $team_selection = $request->get('team_selection');
        $week_selection = $request->get('week_selection');

        $entries = $team_selection == 'all' ? \App\Department::where('name', 'like', '%UK Web Hosting %')->get() : \App\Department::where('departmentid', '=', $team_selection)->get();

        switch ($type) {
            case 'fo_go':
                $breakdown = [
                    'name' => 'SAS Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
                    'headers' => ['Team', 'Calls', 'Sales GO + FO', 'GO +', 'FO +', 'CR GO+FO (Sales/Calls)'],
                    'headerStyle' => ['', '', '', '', '', ''],
                    'data' => []
                ];

                foreach ($entries as $entry) {
                    if ($request->has('date_start') && $request->has('date_end')) {
                        $start = $request->get('date_start');
                        $end = $request->get('date_end');
                        $fo = $entry->upsells()->dateRange($start, $end)->valid()->fo()->count();
                        $go = $entry->upsells()->dateRange($start, $end)->valid()->go()->count();
                        $calls = $entry->cases()->calls()->dateRange($start, $end)->sum('case_count');
                    } else {
                        $fo = $entry->upsells()->weekly($week_selection)->valid()->fo()->count();
                        $go = $entry->upsells()->weekly($week_selection)->valid()->go()->count();
                        $calls = $entry->cases()->calls()->weekly($week_selection)->sum('case_count');
                    }
                    $total = $fo + $go;
                    $breakdown['data'][] = [
                        $entry->name, $calls, $total, $go, $fo, $total ? round((($total) / $calls) * 100, 2) . ' %' : 0 . ' %'
                    ];
                }
                break;
            case 'sas_breakdown':
                break;
            case 'listlocal';
                break;
            case 'difm':
                break;
            case 'cloud':
                break;
            case 'dedicated':
                break;
            case 'virtual':
                break;
            case 'classic':
                break;
            case 'email':
                break;
            case 'ebusiness':
                break;
            case 'marketing':
                break;
            case 'office':
                break;
            case 'domain':
                break;
        }

        $data['breakdown'] = $breakdown;
        \Excel::create('SAS-' . date("Y-m-d"), function($excel) use($data) {
            $excel->sheet('SAS', function($sheet) use($data) {
                $sheet->loadView('perfmanagement.csvreport', array('data' => $data));
            });
        })->download('xlsx');
    }

    public function UploadPayout() {
        $data['page_title'] = 'SAS Payout Breakdown';
        $data['page_desc'] = 'Allow SAS Consultants to upload Payout Breakdown CSV/Excel file in MIS-EWS';
        $data['perfurl'] = 'sas/upload';
        return view('perfmanagement.payoutupload', $data);
    }
    
    public function uploadBreakdown(){
        if(in_array(Auth::user()->roles, array('SAS'))){
            $data['page_title'] = 'SAS Payout Breakdown';
            $data['page_desc'] = 'Allow SAS Consultants to upload Payout Breakdown CSV/Excel file in MIS-EWS';
            $data['perfurl'] = 'sas/upload_breakdown';
            return view('saspayouts.payoutbreakdown', $data);
        }
    }

    public function importExcel(Request $request) {
        if (Input::hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {

                    })->get();
            if (!empty($data) && $data->count()) {
                foreach ($data as $key => $value) {
                    $insert[] = ['month' => $value->month,
                        'sales_date' => $value->sales_date,
                        'cw' => $value->cw,
                        'contract_id' => $value->contract_id,
                        'customer_id' => $value->customer_id,
                        'person_id' => $value->person_id,
                        'fname' => $value->firstname,
                        'lname' => $value->lastname,
                        'product_id' => $value->product_id,
                        'product_desc' => $value->product_desc,
                        'prev_product_id' => $value->previous_product_id,
                        'prev_product_desc' => $value->previous_product_desc,
                        'tc_value' => $value->tc_value,
                        'upside_down' => $value->up_side_down,
                        'country' => $value->country,
                        'cd_team_id' => $value->cd_team_id,
                        'service_provider' => $value->serviceprovider,
                        'location' => $value->location,
                        'mc_check' => $value->mc_check,
                        'ops_sales_cluster' => $value->ops_sales_cluster,
                        'ops_sales_cluster_compact' => $value->ops_sales_cluster_compact,
                        'transaction' => $value->transaction,
                        'department' => $value->department,
                        'upsells' => $value->upsells,
                        'full_name' => $value->full_name,
                        'remarks' => $value->remarks,
                        'comments' => $value->comments,
                        'product_price' => $value->product_price,
                        'invoice' => $value->invoice_gross,
                        'logged_by' => $value->logged_by,
                        'validation_date' => date('Y-m-d', strtotime(addslashes($value->validation_date))),
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s")];
                }

                if (!empty($insert)) {
                    DB::table('sas_payout')->insert($insert);

                    $duplicates = array();
                    $unique = array();

                    for ($x = 0; $x < count($insert); $x++) {
                        $duplicates[] = $insert[$x]['person_id'];
                    }

                    $unique = array_values(array_unique($duplicates));
                    for ($x = 0; $x < count($unique); $x++) {
                        $agent = \App\Employee::where('uid', $unique[$x])->first();

                        Mail::send('perfmanagement.saspayoutemail', $unique, function ($message) use ($agent) {
                            $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
                            $message->to($agent->email, $agent->name)->subject('1&1 SAS Payout');
                            $message->cc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
                        });
                    }
                }
            }
            return redirect('sas/payouts');
        }
    }
    
    public function get_uid($agent){
        $user = Employee::where(\DB::raw("CONCAT(fname,' ',lname)"), $agent)->first();
        if(isset($user->uid)){
            return $user->uid;
        }else{
            return 0;
        }
        
    }
    
    public function importBreakdown(Request $request){
        if (Input::hasFile('import_file')) {
            $path = Input::file('import_file')->getRealPath();
            $data = Excel::load($path, function($reader) {

                    })->get();
            if (!empty($data) && $data->count()) {
                foreach ($data as $key => $value) {
                    $insert[] = 
                        ['uid' => $this->get_uid($value->agent),
                         'payout_cycle' => $value->month,
                         'team' => $value->team,
                         'agent' => $value->agent,
                         'contract_id' => $value->contract,
                         'product' => $value->product,
                         'upsell' => $value->upsell,
                         'logged_by' => Auth::user()->uid,
                         'created_at' => date("Y-m-d H:i:s"),
                         'updated_at' => date("Y-m-d H:i:s")];
                }

                if (!empty($insert)) {
                    DB::table('sas_payout_breakdown')->insert($insert);
                    $duplicates = array();
                    $unique = array();
                    $data = array();

                    for ($x = 0; $x < count($insert); $x++) {
                        $duplicates[] = $insert[$x]['uid'];
                    }

                    $unique = array_values(array_unique($duplicates));
                    for ($x = 0; $x < count($unique); $x++) {
                        if($unique[$x] != 0){
                            $agent = Employee::where('uid', $unique[$x])->where('active', 1)->first();
                            if(isset($agent->uid)){
                                $packages = SasPayoutBreakdown::where('uid', $unique[$x])->get();
                                $max = SasPayoutBreakdown::where('uid', $unique[$x])->max('payout_cycle');
                                $data['month'] = date("F", strtotime('2017-'.substr($max, -2, 2).'-01'));
                                $value = count($agent);
                                $data['emp'] = $agent->fname;
                                $data['count_packages'] = count($packages) / $value;

                                Mail::send('saspayouts.breakdownemail', $data, function ($message) use ($agent) {
                                    $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
                                    $message->to($agent->email, $agent->name)->subject('1&1 SAS Payout Breakdown');
//                                    $message->to('arjay.villanueva@1and1.com', 'Arjay Villanueva')->subject('1&1 SAS Payout Breakdown');
                                    $message->cc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
                                });
                            }else{
                                $max = SasPayoutBreakdown::where('uid', $unique[$x])->max('payout_cycle');
                                $data['month'] = date("F", strtotime('2017-'.substr($max, -2, 2).'-01'));
                                $logged_by = Auth::user();
                                $data['emp'] = '';
                                $data['count_packages'] = '';
                                Mail::send('saspayouts.breakdownemail', $data, function ($message) use ($logged_by) {
                                    $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
                                    $message->to($logged_by->email, $logged_by->name)->subject('1&1 SAS Payout Breakdown');
//                                    $message->to('arjay.villanueva@1and1.com', 'Arjay Villanueva')->subject('1&1 SAS Payout Breakdown');
                                    $message->cc('arjay.villanueva@1and1.com', 'Arjay Villanueva');
                                });
                            }
                        }
                    }
                }
            }
            return redirect('sas/payout_breakdown');
        }
    }
    
    public function salesPayoutBreakdown(Request $request){
        $wk = $request->has('w') ? $request->get('w') : false;
        $team_selection = [];

        $entries = [];
        switch (Auth::user()->roles) {
            case 'SAS':
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
                $_entries = Auth::user()->subordinates();
                $_entries->push(Auth::user());

                $entries = $_entries->reject(function($value) {
                    return in_array($value->uid, $this->exemptions);
                });
            case 'AGENT':
                $entry = Auth::user();
                break;
            default:
                break;
        }

        $breakdown = [
            'name' => 'Payout Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['id', 'Team', 'Employee', 'Month', 'Contract ID', 'Product', 'Upsell', 'Uploaded By', 'Date Uploaded'],
            'headerStyle' => ['', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        if (Auth::user()->roles == 'AGENT') {
            $max = SasPayoutBreakdown::where('uid', Auth::user()->uid)->max('payout_cycle');
            if ($request->has('w')) {
                $month = $request->get('w');
                $valid = SasPayoutBreakdown::where('uid', Auth::user()->uid)->where('payout_cycle', 'LIKE', '%' .$month .'%')->get();
            }else{
                $valid = SasPayoutBreakdown::where('uid', Auth::user()->uid)->get();
            }
            
            foreach ($valid as $_valid) {
                $sales_date = date('Y-m-d', strtotime($_valid->payout_cycle));
                $emp = Employee::where('uid', $_valid->logged_by)->first();
                $breakdown['data'][] = [
                     $_valid->id, $_valid->team, $_valid->agent, $_valid->payout_cycle,
                    $_valid->contract_id, $_valid->product, $_valid->upsell, $emp->name, $_valid->created_at
                ];
            }

        }else{
            $max = SasPayoutBreakdown::max('payout_cycle');
            foreach ($entries as $entry) {
                if ($request->has('w')) {
                    $month = $request->get('w');
                    $valid = $entry->payoutbreakdown()->where('payout_cycle', 'LIKE', '%' .$month .'%')->get();
                } else {
                    $valid = $entry->payoutbreakdown()->get();
                }
                
                foreach ($valid as $_valid) {
                    $sales_date = date('Y-m-d', strtotime($_valid->payout_cycle));
                    $emp = Employee::where('uid', $_valid->logged_by)->first();
                    $breakdown['data'][] = [
                         $_valid->id, $_valid->team, $_valid->agent, $_valid->payout_cycle,
                        $_valid->contract_id, $_valid->product, $_valid->upsell, $emp->name, $_valid->created_at
                    ];
                }
            }
        }
        
        
        $data['max'] = substr($max, -2, 2);
        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'SAS Payout Breakdown';
        $data['page_desc'] = 'Displays all SAS Payout Breakdown.';
        $data['team_selection'] = $team_selection;
        $data['perfurl'] = 'sas/payout_breakdown';
        return view('saspayouts.breakdownoverview', $data);
    }

    public function Salespayout(Request $request) {
        $wk = $request->has('w') ? $request->get('w') : false;
        $team_selection = [];

        $entries = [];
        switch (Auth::user()->roles) {
            case 'SAS':
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
                $_entries = Auth::user()->subordinates();
                $_entries->push(Auth::user());

                $entries = $_entries->reject(function($value) {
                    return in_array($value->uid, $this->exemptions);
                });
            case 'AGENT':
                $entry = Auth::user();
                break;
            default:
                break;
        }

        $breakdown = [
            'name' => 'Validation Breakdown ' . ($wk ? 'Week [' . $wk : ($request->has('date_start') && $request->has('date_end') ? '[Date: ' . $request->get('date_start') . ' - ' . $request->get('date_end') : '')) . ']',
            'headers' => ['Employee', 'Sales Date', 'Contract ID', 'Customer ID', 'Product Info', 'Sales Cluster', 'Department', 'Remarks', 'Product Price', 'Invoice (Gross)', 'Date Validated', 'Validated By'],
            'headerStyle' => ['', '', '', '', '', '', '', '', '', '', '', '', '', '', ''],
            'data' => []
        ];

        if (Auth::user()->roles == 'AGENT') {
            if ($request->has('date_start') && $request->has('date_end')) {
                $start = $request->get('date_start');
                $end = $request->get('date_end');
                $valid = $entry->payouts()->dateRange($start, $end)->valid()->where('logged_by', 'yesha')->orderBy('sales_date', 'desc');
            } else {
                $valid = $entry->payouts()->valid()->where('logged_by', 'yesha')->orderBy('sales_date', 'desc');
            }

            foreach ($valid->get() as $_valid) {
                $sales_date = date('Y-m-d', strtotime($_valid->sales_date));
                $breakdown['data'][] = [
                    $_valid->full_name, $sales_date, $_valid->contract_id, $_valid->customer_id,
                    $_valid->product_desc, $_valid->ops_sales_cluster, $_valid->department, $_valid->remarks, $_valid->product_price, $_valid->invoice,
                    $_valid->validation_date, $_valid->logged_by
                ];
            }
        } else {
            foreach ($entries as $entry) {
                if ($request->has('date_start') && $request->has('date_end')) {
                    $start = $request->get('date_start');
                    $end = $request->get('date_end');
                    $valid = $entry->payouts()->dateRange($start, $end)->valid()->where('logged_by', 'yesha')->orderBy('sales_date', 'desc');
                } else {
                    $valid = $entry->payouts()->valid()->where('logged_by', 'yesha')->orderBy('sales_date', 'desc');
                }

                foreach ($valid->get() as $_valid) {
                    $sales_date = date('Y-m-d', strtotime($_valid->sales_date));
                    $breakdown['data'][] = [
                        $_valid->full_name, $sales_date, $_valid->contract_id, $_valid->customer_id,
                        $_valid->product_desc, $_valid->ops_sales_cluster, $_valid->department, $_valid->remarks, $_valid->product_price, $_valid->invoice,
                        $_valid->validation_date, $_valid->logged_by
                    ];
                }
            }
        }

        $data['breakdown'] = $breakdown;
        $data['page_title'] = 'SAS Payout';
        $data['page_desc'] = 'Displays all SAS Payouts.';
        $data['team_selection'] = $team_selection;
        $data['perfurl'] = 'sas/payouts';
        return view('perfmanagement.payoutoverview', $data);
    }

}
