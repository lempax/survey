<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentReleasedRate extends Model {

    public $table = 'agent_released';
    public $fillable = ['rid',
        'team',
        'jan_total',
        'jan_calls',
        'jan_ave',
        'feb_total',
        'feb_calls',
        'feb_ave',
        'mar_total',
        'mar_calls',
        'mar_ave',
        'april_total',
        'april_calls',
        'april_ave',
        'may_total',
        'may_calls',
        'may_ave',
        'june_total',
        'june_calls',
        'june_ave',
        'july_total',
        'july_calls',
        'july_ave',
        'aug_total',
        'aug_calls',
        'aug_ave',
        'sept_total',
        'sept_calls',
        'sept_ave',
        'oct_total',
        'oct_calls',
        'oct_ave',
        'nov_total',
        'nov_calls',
        'nov_ave',
        'dec_total',
        'dec_calls',
        'dec_ave',
    ];

}
