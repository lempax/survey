<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        Commands\FetchData::class,
        Commands\ProcessData::class,
        Commands\LdapSync::class,
        Commands\SendNotification::class,
        Commands\importSignature::class,
        Commands\notifyDueActionPlans::class,
        Commands\SendITReport::class,
        Commands\BirthdayNotifier::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        // Sync employees table daily at midnight.
        $schedule->command('mis:ldapsync')
                ->daily()
                ->appendOutputTo(storage_path() . '/logs/mis.ldapsync.log');

        // Fetches new emails from assigned mailbox and process it 
        // twice daily at 2:35am & 4:35pm
        $schedule->command('mis:fetchdata')->cron('35 2,16 * * * *')
                ->appendOutputTo(storage_path() . '/logs/mis.fetchdata.log')
                ->after(function() {
                    $query = \DB::table('datasource')->where('status', 'fetched');
                    foreach ($query->get() as $row) {
                        \Artisan::call('mis:processdata', [
                            'filepath' => storage_path('app/datasource/') . $row->filepath,
                            'type' => $row->type,
                            '--tid' => $row->tid
                        ]);
                    }
                    $query->update(['status' => 'processed', 'updated_at' => \Carbon\Carbon::now()]);
                });

        // Fetches emails for the previous week and process it 
        // every tuesday at 4:10pm
        $schedule->command('mis:fetchdata')->weekly()->tuesdays()->at('16:10')
                ->appendOutputTo(storage_path() . '/logs/mis.fetchdata.log')
                ->after(function() {
                    $query = \DB::table('datasource')->where('status', 'fetched');
                    foreach ($query->get() as $row) {
                        \Artisan::call('mis:processdata', [
                            'filepath' => storage_path('app/datasource/') . $row->filepath,
                            'type' => $row->type,
                            '--tid' => $row->tid,
                            '--prev' => true
                        ]);
                    }
                    $query->update(['status' => 'processed', 'updated_at' => \Carbon\Carbon::now()]);
                });

        // Send email notifications to superiors
        // starting Wednesday until Sunday at 5:00pm
        $schedule->command('mis:notify')->dailyAt('1700')->when(function() {
            return !in_array(date('D'), array('Mon', 'Tue'));
        })->appendOutputTo(storage_path() . '/logs/mis.notification.log');
        
        //twice daily at 3:00 AM and 3:00 PM
        $schedule->command('mis:notifyDueActionPlans')->twiceDaily(3,15);
//         $schedule->command('mis:notifyDueActionPlans')->everyMinute();
//         
        //Send email report every monday of the week at 9AM
        $schedule->command('mis:send-weekly-report')->weekly()->mondays()->at('9:00');
        
        //Send birthday greetings every 12 midnight
        $schedule->command('mis:birthdaynotification')
                ->daily()
                ->appendOutputTo(storage_path() . '/logs/mis.bdaynotifier.log');
    }

}
