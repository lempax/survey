<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CosmoCalls extends Model
{

    protected $table = 'cosmocalls';
    protected $fillable = [
        'date', 'uid', 'agent_name', 'calls_handled', 'outgoing_calls',
        'conference_transferred_calls', 'tid'
    ];

    public function user() {
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
    
    public function scopeDateRange($query, $start, $end) {
        return $query->whereBetween('date', [$start, $end]);
    }
    
    public function scopeWeekly($query, $week = false) {
        $yearweek = $week ? date('oW') - (date('W') - $week) : date('oW');
        return $query->where(\DB::raw('YEARWEEK(date,1)'), '=', $yearweek);
    }
    
    public function scopeMonthly($query, $month = false) {
        if ($month) {
            $mo = $month <= 9 ? '0' . $month : $month;
            return $query->whereMonth('date', '=', $mo);
        } else
            return $query->whereMonth('date', '=', date('m'));
    }

}
