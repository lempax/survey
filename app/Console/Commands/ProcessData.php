<?php

namespace App\Console\Commands;

use App\SSECase;
use App\QFBReturns;
use App\SASUpsells;
use App\CosmoCalls;
use App\Cosmocom;
use Illuminate\Console\Command;

class ProcessData extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mis:processdata
            {filepath : Location of the data source file.}
            {type=cases : Type of data to be processsed: [cases|quality|sas|cosmo|cosmocalls].}
            {--tid= : Optional: transaction ID for this process}
            {--prev : Optional: determines if this data is for the previous week}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '(MIS-EWS) Process the newly fetched data from Microstrategy and/or other sources.';

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
        $filepath = $this->argument('filepath');
        if (file_exists($filepath)) {
            $this->info('Processing data file located at: ' . $filepath);
            $fh = fopen($filepath, 'rb') or die("ERROR OPENING DATA");
            $linecount = 0;
            while (fgets($fh) !== false) {
                $linecount++;
            }
            fclose($fh);

            $resource = fopen($filepath, "r");

            switch ($this->argument('type')) {
                case 'cases':
                    $this->processCases($resource, $linecount);
                    break;
                case 'quality':
                    $this->processQuality($resource, $linecount);
                    break;
                case 'sas':
                    $this->processSAS($filepath);
                    break;
                case 'cosmo':
                    $this->processCosmo($resource, $linecount);
                    break;
                case 'cosmocalls':
                    $this->processCosmoCalls($resource, $linecount);
                    break;
            }

            fclose($resource);
            $this->line("\n");
            $this->info('Successfully processed data file ' . $filepath);
        } else
            $this->error('Could not locate data source file.');
    }

    private function processCases($resource, $linecount) {
        $bar = $this->output->createProgressBar($linecount);
        $tid = $this->option('tid') ? $this->option('tid') : time();
        $yw = $this->option('prev') ? date('oW') - 1 : date('oW');

        // Delete existing data for the given week and reset auto incrementing ids.
        $prev_max_id = SSECase::max('id');
        SSECase::where(\DB::raw('YEARWEEK(date,1)'), '=', $yw)->delete();
        if ($prev_max_id >= SSECase::max('id'))
            \DB::statement('ALTER TABLE case_tracking AUTO_INCREMENT = ' . (SSECase::max('id') + 1));

        while (( $data = fgetcsv($resource, 0, "~") ) !== FALSE) {
            $num = count($data);
            if ($num <= 1)
                continue;
            if ($this->sanitize_str($data[0]) == "SSE Case Reference Date (WP Balance)")
                continue;

            $dd = array();
            for ($c = 0; $c < $num; $c++) {
                $dd[] = $this->sanitize_str($data[$c]);
            }

            $rdata = [
                'date' => date('Y-m-d', strtotime($dd[0])),
                'medium' => ($dd[1] == 'EML' ? 'Mail' : 'Telefon'),
                'workpool' => $dd[2],
                'tracking1' => $dd[3],
                'tracking2' => $dd[4],
                'product_line' => $dd[5],
                'product_id' => $dd[7],
                'product_desc' => $dd[6],
                'caseid' => $dd[8],
                'customerid' => $dd[9],
                'agent_id' => $dd[10],
                'uid' => $dd[11],
                'agent_name' => $dd[12],
                'team' => $dd[13],
                'case_count' => $dd[15],
                'bl_count' => $dd[16],
                'avg_case_editing_time' => $dd[17],
                'avg_editing_time' => $dd[18],
                'avg_sas_editing_time' => $dd[19],
                'tid' => $tid
            ];

            SSECase::create($rdata);
            $bar->advance();
        }

        $bar->finish();
    }

    private function processQuality($resource, $linecount) {
        $bar = $this->output->createProgressBar($linecount);
        $tid = $this->option('tid') ? $this->option('tid') : time();
        $yw = $this->option('prev') ? date('oW') - 1 : date('oW');

        // Delete existing data for the given week and reset auto incrementing ids.
        $prev_max_id = QFBReturns::max('id');
        QFBReturns::where(\DB::raw('YEARWEEK(date,1)'), '=', $yw)->delete();
        if ($prev_max_id >= QFBReturns::max('id'))
            \DB::statement('ALTER TABLE quality_tracking AUTO_INCREMENT = ' . (QFBReturns::max('id') + 1));

        while (( $data = fgetcsv($resource, 0, "~") ) !== FALSE) {
            $num = count($data);
            if ($num <= 1)
                continue;
            if ($this->sanitize_str($data[0]) == "Date")
                continue;

            $dd = array();
            for ($c = 0; $c < $num; $c++) {
                $dd[] = $this->sanitize_str($data[$c]);
            }

            $rdata = [
                'date' => date('Y-m-d', strtotime($dd[0])),
                'medium' => $dd[2],
                'workpool' => $dd[12],
                'product_id' => $dd[10],
                'product_desc' => $dd[11],
                'caseid' => $dd[1],
                'qfb_competence' => $dd[3],
                'qfb_first_request' => $dd[4],
                'qfb_friendliness' => $dd[5],
                'qfb_request_customer_effort_contact' => $dd[6],
                'qfb_request_resolved' => $dd[7],
                'qfb_response' => $dd[8],
                'qfb_solution' => $dd[9],
                'qfb_netpromoter_score' => $dd[17] . ',' . $dd[18],
                'agent_id' => $dd[10],
                'uid' => $dd[13],
                'agent_name' => $dd[14],
                'team' => $dd[15],
                'department' => $dd[16],
                'qfb_comment_praise' => $dd[22],
                'qfb_comment_suggestions' => $dd[23],
                'tid' => $tid
            ];

            QFBReturns::create($rdata);
            $bar->advance();
        }

        $bar->finish();
    }

    private function processSAS($filepath) {
        \Excel::load($filepath, function($reader) {
            $tid = $this->option('tid') ? $this->option('tid') : time();
            $results = $reader->get();
            $bar = $this->output->createProgressBar($results->count());

            $this->info('Reading all ' . $results->count() . ' rows from excel file');
            SASUpsells::truncate();
            foreach ($results as $row) {
                $data = $row->toArray();
                $data["sales_date"] = date('Y-m-d', strtotime((int) $data["sales_date"]));
                $data["tid"] = $tid;
                SASUpsells::create($data);

                $bar->advance();
            }
            $bar->finish();
        });
    }

    private function processCosmo($resource, $linecount) {
        $bar = $this->output->createProgressBar($linecount);
        $tid = $this->option('tid') ? $this->option('tid') : time();

        while (( $data = fgetcsv($resource, 0, ",") ) !== FALSE) {
            $num = count($data);
            if ($num <= 1)
                continue;
            if ($this->sanitize_str($data[0]) == "AgentName")
                continue;

            $dd = array();
            for ($c = 0; $c < $num; $c++) {
                $dd[] = $this->sanitize_str($data[$c]);
            }

            if ($dd[4] != 'Released')
                continue;

            $emp = \App\Employee::where(\DB::raw('concat(fname," ",lname)'), '=', $dd[0])->first();

            $rdata = [
                'date' => date('Y-m-d', strtotime($dd[1])),
                'uid' => $emp ? $emp->uid : 0,
                'agent_name' => $dd[0],
                'state' => $dd[4],
                'duration' => $dd[5],
                'avg_statetime' => $dd[6],
                'state_ratio' => $dd[7],
                'total_duration' => $dd[8],
                'tid' => $tid
            ];

            Cosmocom::create($rdata);
            $bar->advance();
        }

        $bar->finish();
    }

    private function processCosmoCalls($resource, $linecount) {
        $bar = $this->output->createProgressBar($linecount);
        $tid = $this->option('tid') ? $this->option('tid') : time();

        while (( $data = fgetcsv($resource, 0, ",") ) !== FALSE) {
            $num = count($data);
            if ($num <= 1)
                continue;
            if ($this->sanitize_str($data[0]) == "AgentName")
                continue;

            $dd = array();
            for ($c = 0; $c < $num; $c++) {
                $dd[] = $this->sanitize_str($data[$c]);
            }

            if (!empty($dd[25]))
                continue;

            $emp = \App\Employee::where(\DB::raw('concat(fname," ",lname)'), '=', $dd[2])->first();

            $rdata = [
                'date' => date('Y-m-d', strtotime($dd[0])),
                'uid' => $emp ? $emp->uid : 0,
                'agent_name' => $dd[2],
                'calls_handled' => $dd[11],
                'outgoing_calls' => $dd[13],
                'conference_transferred_calls' => $dd[14],
                'tid' => $tid
            ];

            CosmoCalls::create($rdata);
            $bar->advance();
        }

        $bar->finish();
    }

    private function sanitize_str($_str) {
        $str = str_replace('"', '', $_str);
        return trim(urldecode(html_entity_decode(strip_tags($str))));
    }

}
