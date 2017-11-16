<?php

namespace App\Console\Commands;

use DB;
use Storage;
use Carbon\Carbon;
use Illuminate\Console\Command;

use PhpImap\Mailbox as ImapMailbox;
use PhpImap\IncomingMail;
use PhpImap\IncomingMailAttachment;

class FetchData extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mis:fetchdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '(MIS-EWS) Fetch latest data from Microstrategy and/or other sources via assigned email.';

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
        $this->info('[' . Carbon::now() . ']');
        $this->info('Fetching latest data from assigned mailbox...');
        
        $mailbox = new ImapMailbox(env('PHPIMAP_PATH'), env('PHPIMAP_USER'), env('PHPIMAP_PASS'), storage_path('app/datasource/temp/'), 'US-ASCII');
        $mailsIds = $mailbox->searchMailbox('UNSEEN');
        
        $fileCtr = 0;
        $tid = time();
        foreach($mailsIds as $Id) {
            $mail = $mailbox->getMail($Id);
            
            foreach ($mail->getAttachments() as $attachment) {
                if ($attachment->disposition == 'attachment') {
                    $this->info('Saving received data file: ' . $attachment->name);
                    if ($this->getFileType($attachment->filePath) == 'application/zip') {
                        $zip = new \ZipArchive;
                        $fileinfo = '';
                        if ($zip->open($attachment->filePath) === TRUE) {
                            $zip->extractTo(storage_path('app/datasource/temp'));
                            $fileinfo = $zip->statIndex(0);
                            $zip->close();
                        }
                        $filename = time() . '_' . preg_replace('/\s+/', '_', $fileinfo['name']);
                        Storage::move('datasource/temp/' . $fileinfo['name'], 'datasource/' . $filename);
                    } else {
                        $filename = time() . '_' . preg_replace('/\s+/', '_', $attachment->name);
                        rename($attachment->filePath, storage_path('app/datasource/') . $filename);
                    }

                    $type = '';
                    if (str_contains($filename, 'SSE_Case_Tracking'))
                        $type = 'cases';
                    elseif (str_contains($filename, 'QFB_Reports'))
                        $type = 'quality';
                    elseif (str_contains($filename, 'SaS_Raw_data_Cebu'))
                        $type = 'sas';
                    elseif (str_contains($filename, 'Agent_Management_(dynamic_date)'))
                        $type = 'cosmocalls';
                    else
                        $type = 'cosmo';

                    DB::table('datasource')->insert([
                        'tid' => $tid,
                        'type' => $type,
                        'filepath' => $filename,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ]);

                    $fileCtr++;
                    break;
                }
            }
        }
        $this->info('Removing temporary files...');
        Storage::delete(Storage::files('datasource/temp/'));
        
        $this->info('[' . Carbon::now() . '] Total files received: ' . $fileCtr);
    }
    
    private function getFileType($path) {
        return finfo_file(finfo_open(FILEINFO_MIME_TYPE), $path);
    }

}
