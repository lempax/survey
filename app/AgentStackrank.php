<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentStackrank extends Model {

    public $table = 'agent_stack_rank';
    public $fillable = ['rid',
        'agent',
        'team',
        'jan_cr',
        'jan_feed',
        'feb_cr',
        'feb_feed',
        'mar_cr',
        'mar_feed',
        'april_cr',
        'april_feed',
        'may_cr',
        'may_feed',
        'june_cr',
        'june_feed',
        'july_cr',
        'july_feed',
        'aug_cr',
        'aug_feed',
        'sept_cr',
        'sept_feed',
        'oct_cr',
        'oct_feed',
        'nov_cr',
        'nov_feed',
        'dec_cr',
        'dec_feed',
        'ave_cr',
        'rank_cr',
        'jan_q',
        'feb_q',
        'mar_q',
        'april_q',
        'may_q',
        'june_q',
        'july_q',
        'aug_q',
        'sept_q',
        'oct_q',
        'nov_q',
        'dec_q',
        'ave_q',
        'rank_q',
        'jan_nps',
        'feb_nps',
        'mar_nps',
        'april_nps',
        'may_nps',
        'june_nps',
        'july_nps',
        'aug_nps',
        'sept_nps',
        'oct_nps',
        'nov_nps',
        'dec_nps',
        'ave_nps',
        'rank_nps',
        'jan_prod',
        'feb_prod',
        'mar_prod',
        'april_prod',
        'may_prod',
        'june_prod',
        'july_prod',
        'aug_prod',
        'sept_prod',
        'oct_prod',
        'nov_prod',
        'dec_prod',
        'ave_prod',
        'rank_prod',
        'jan_sas',
        'feb_sas',
        'mar_sas',
        'april_sas',
        'may_sas',
        'june_sas',
        'july_sas',
        'aug_sas',
        'sept_sas',
        'oct_sas',
        'nov_sas',
        'dec_sas',
        'ave_sas',
        'rank_sas',
        'jan_rel',
        'feb_rel',
        'mar_rel',
        'april_rel',
        'may_rel',
        'june_rel',
        'july_rel',
        'aug_rel',
        'sept_rel',
        'oct_rel',
        'nov_rel',
        'dec_rel',
        'ave_rel',
        'rank_rel',
        'jan_aht',
        'feb_aht',
        'mar_aht',
        'april_aht',
        'may_aht',
        'june_aht',
        'july_aht',
        'aug_aht',
        'sept_aht',
        'oct_aht',
        'nov_aht',
        'dec_aht',
        'ave_aht',
        'rank_aht',
        'total',
        'overall'
    ];

}
