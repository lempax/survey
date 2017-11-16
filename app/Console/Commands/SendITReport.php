<?php

namespace App\Console\Commands;

use Mail;
use App\Employee;
use App\Department;
use App\EosReports;
use Illuminate\Console\Command;

class SendITReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mis:send-weekly-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Weekly Report to IT Manager for all IT EOS.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $hardware = 0;
        $software = 0;
        $cosmocom = 0;
        $network = 0;
        $virus = 0;
        $ups = 0;
        $mis = 0;

        $eos_week = EosReports::where(\DB::raw('YEARWEEK(created_at,1)'), '=', \DB::raw('YEARWEEK(curdate() - INTERVAL 1 WEEK, 1)'))->get();

        if (!empty($eos_week)) {
            foreach ($eos_week AS $eosreport) {
                if (!empty($eosreport->tickets)) {
                    $tickets = json_decode($eosreport->tickets);
                    foreach ($tickets AS $_tickets) {
                        switch ($_tickets->category) {
                            case "hardware":
                                $hardware++;
                                break;
                            case "software":
                                $software++;
                                break;
                            case "ups":
                                $ups++;
                                break;
                            case "cosmocom":
                                $cosmocom++;
                                break;
                            case "network":
                                $network++;
                                break;
                            case "mis":
                                $mis++;
                                break;
                            case "virus":
                                $virus++;
                                break;
                        }
                    }
                }
            }
        }

        $data['hardware'] = $hardware;
        $data['software'] = $software;
        $data['ups'] = $ups;
        $data['cosmocom'] = $cosmocom;
        $data['network'] = $network;
        $data['mis'] = $mis;
        $data['virus'] = $virus;
        $user = '';

        Mail::send('eos.reports', $data, function ($message) use ($user) {
            $message->from('no-reply@mis-ews.ph.schlund.net', 'MIS-EWS');
            $message->to('kristian.amparado@1and1.com', '1&1 IT Ticket Report')->subject('1&1 IT Ticket Report');
        });
    }
}
