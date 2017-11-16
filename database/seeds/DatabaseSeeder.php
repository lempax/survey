<?php

use Illuminate\Database\Seeder;
use App\US_emails as US_emails;
use App\USTechPilots as USTechPilots;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        USTechPilots::create([
            'pilot' => 'US_1u1_WH_ClassicHosting_1st'
        ]);
        
        USTechPilots::create([
            'pilot' => 'US_1u1_WH_General_Support_1st'
        ]);
        
        USTechPilots::create([
            'pilot' => 'US_1u1_WH_General_Support_RPT_1st'
        ]);
        
        USTechPilots::create([
            'pilot' => 'US_1u1_WH_Technical_2nd'
        ]);
        
        USTechPilots::create([
            'pilot' => 'US_1u1_WH_Technical_Email_1st'
        ]);
        
        USTechPilots::create([
            'pilot' => 'US_1u1_WH_Technical_Domain_1st'
        ]);
        
        USTechPilots::create([
            'pilot' => 'US_1u1_WH_PHP_PINC_1st'
        ]);
        
        USTechPilots::create([
            'pilot' => 'US_1u1_WH_Technical_1st_OF'
        ]);
        
        US_emails::create([
            'workpool' => 'Hosting.US.ClassicHosting.1st'
        ]);
        
        US_emails::create([
            'workpool' => 'Hosting.US.Mail.1st'
        ]);
        
        US_emails::create([
            'workpool' => 'Hosting.US.Domains.1st'
        ]);
        
        US_emails::create([
            'workpool' => 'Hosting.US.Billing.1st'
        ]);
    }
}
