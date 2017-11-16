<?php

use Illuminate\Database\Seeder;
use App\USTechPilots as USTechPilots;

class UstechpilotsSeeder extends Seeder
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
        
    }
}
