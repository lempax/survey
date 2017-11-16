<?php

namespace App\Console\Commands;

use Mail;
use Illuminate\Console\Command;

class SendNotification extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mis:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '(MIS-EWS) Send email notification to all superiors';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        //$ops = [];
        $techsuperiors = \App\Employee::whereIn('roles', ['SUPERVISOR', 'MANAGER', 'SOM'])->get();
        foreach ($techsuperiors as $superior) {
            if ($superior->department == NULL)
                continue;
            if (in_array($superior->department->market, ['US', 'UK'])) {
                $entries = [];
                $tname = '';
                switch ($superior->roles) {
                    case 'MANAGER':
                    case 'SOM':
                        $entries = $superior->teams()->reject(function($value) use ($superior) {
                            $exemptions = $superior->settings()->type('filtered_list')->first() ?
                                    json_decode($superior->settings()->type('filtered_list')->first()->entries) : [];
                            return in_array($value->uid, $exemptions);
                        });
                        $tname = 'Teams';
                        break;
                    case 'SUPERVISOR':
                        $entries = $superior->subordinates()->reject(function($value) use ($superior) {
                            $exemptions = $superior->settings()->type('filtered_list')->first() ?
                                    json_decode($superior->settings()->type('filtered_list')->first()->entries) : [];
                            return in_array($value->uid, $exemptions);
                        });
                        $entries->push($superior);
                        $tname = 'Agents';
                        break;
                }

                $stats = collect();
                foreach ($entries as $entry) {
                    $cases = $entry->cases()->weekly()->sum('case_count');
                    $calls = $entry->cases()->weekly()->calls()->sum('case_count');
                    $emails = $entry->cases()->weekly()->emails()->sum('case_count');
                    $blacklist = $entry->cases()->weekly()->blackListed()->sum('case_count');
                    $sales = $entry->upsells()->weekly()->valid()->count();
                    $returns = $entry->feedbacks()->weekly()->count();
                    $yes_count = $entry->feedbacks()->weekly()->requestSolved()->count();
                    $cosmo = $entry->cosmocom()->weekly()->get();
                    $rdata = [
                        $entry->name,
                        $calls,
                        $emails,
                        $cases,
                        $blacklist,
                        $cases ? round(($blacklist / $cases) * 100, 2) : 0,
                        $returns,
                        $yes_count,
                        $returns ? round(($yes_count / $returns) * 100, 2) : 0,
                        $sales,
                        $calls ? round(($sales / $calls) * 100, 2) : 0,
                        $cosmo->count() ? round($cosmo->where('state', 'Released')->avg('state_ratio'), 2) : '',
                        $cosmo->count() ? round($cosmo->where('state', 'Released')->sum('total_duration'), 2) : '',
                        $cosmo->count() ? round($cosmo->where('state', 'Released')->avg('total_duration'), 2) : ''
                    ];
                    $stats->push($rdata);
                }

                Mail::send('email', ['ops' => $stats, 'tname' => $tname], function($msg) use ($superior) {
                    $msg->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
                    $msg->to($superior->email, $superior->name)->subject('MIS-EWS Notification');
                });
            }
        }
    }

}
