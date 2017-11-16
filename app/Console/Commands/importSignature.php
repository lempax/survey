<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use File;
class importSignature extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mis:importSignature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '(MIS-EWS) Import signatures of employee to database';

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
        $path = storage_path().'/images/';
        $images = File::allFiles($path);
        foreach($images as $file)
        {
        $uid = pathinfo($file,PATHINFO_FILENAME);
        $path = pathinfo($file,PATHINFO_BASENAME);
        $imageData = base64_encode(file_get_contents($file));
        DB::table('signatures')->insert([
            'uid'=> $uid,
            'image'=> $imageData,
            'name'=> $path]);
         $this->info('Successfully inserted '.$path. ' into database');
        }

    }
}
