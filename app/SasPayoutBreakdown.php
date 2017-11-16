<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SasPayoutBreakdown extends Model
{
    protected $table = 'sas_payout_breakdown';
    protected $fillable = ['uid', 'team', 'agent', 'payout_cycle', 'contract_id', 'product', 'upsell', 'logged_by'];
    protected $dates = ['date'];

    public function user() {
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
    
    public function scopeMonthly($query, $month = false){
        return $query->where('payout_cycle', 'LIKE', $month);
    }
}
