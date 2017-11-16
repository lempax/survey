<?php

use Illuminate\Database\Seeder;
use App\US_emails as US_emails;

class Us_emailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
