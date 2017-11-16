<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentSas extends Model {

    public $table = 'agent_sas';
    public $fillable = ['rid',
        'team',
        'jan_sas',
        'jan_calls',
        'jan_cr',
        'feb_sas',
        'feb_calls',
        'feb_cr',
        'mar_sas',
        'mar_calls',
        'mar_cr',
        'april_sas',
        'april_calls',
        'april_cr',
        'may_sas',
        'may_calls',
        'may_cr',
        'june_sas',
        'june_calls',
        'june_cr',
        'july_sas',
        'july_calls',
        'july_cr',
        'aug_sas',
        'aug_calls',
        'aug_cr',
        'sept_sas',
        'sept_calls',
        'sept_cr',
        'oct_sas',
        'oct_calls',
        'oct_cr',
        'nov_sas',
        'nov_calls',
        'nov_cr',
        'dec_sas',
        'dec_calls',
        'dec_cr',
    ];

}
