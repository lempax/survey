<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;


class BirthdayNotifier extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mis:birthdaynotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $employees = \App\Employee::active()->get();
        
        foreach ($employees as $employee) {
            if ($employee->bdate->isBirthday() && $employee->active) {
                $data['user'] = $employee;
                $filename = $employee->username;
                $path = public_path() . '/assets/uploadedcards/' . $filename . ".jpg";

                if (file_exists($path)) {
                    $card = \Image::make(public_path() . '/assets/uploadedcards/' . $filename . ".jpg");
                } else {
                    $bdaycards = collect(['bdaycard1.jpg', 'bdaycard2.jpg', 'bdaycard3.jpg', 'bdaycard4.jpg', 'bdaycard5.jpg']);
                    $shuffled = $bdaycards->shuffle()->toArray();
                    $bday = reset($shuffled);
                    $card = \Image::make(public_path() . '/assets/' . $bday);

                    $card->insert($employee->image, 'left', 150, 0);
                    $card->text($employee->name, 500, 260, function($font) {
                        $font->file(public_path() . '/assets/verdana.ttf');
                        $font->size(35);
                        $font->color('#000000');
                        $font->align('center');
                        $font->valign('top');
                    });

                    $card->text($employee->department->name, 500, 310, function($font) {
                        $font->file(public_path() . '/assets/verdana.ttf');
                        $font->size(20);
                        $font->color('#000000');
                        $font->align('center');
                        $font->valign('top');
                    });
                }
                
                $data['bdaycard'] = $card->encode('jpg');

                if (file_exists($path)) {
                    $this->info('Sending birthday greetings to ' . $employee->name);
                    \Mail::send('bdayemail', $data, function ($message) use ($employee) {
                        $message->from($employee->superior->email, 'Birthday Notifier');
                        $message->to($employee->email, $employee->name)
                                ->bcc('info-cebu@1and1.com')
                                ->subject('Birthday Greetings from 1&1');
                    });
                } else {
                    $this->info('Sending birthday greetings to ' . $employee->name);
                    \Mail::send('bdayemail', $data, function ($message) use ($employee) {
                        $message->from('ana.dellosa@1and1.com', 'Birthday Notifier');
                        $message->to($employee->email, $employee->name)
                                ->bcc('info-cebu@1and1.com')
                                ->subject('Birthday Greetings from 1&1');
                    });
                }
            }
        }
    }
}
