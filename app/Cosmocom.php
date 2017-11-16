<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cosmocom extends Model
{

    protected $table = 'cosmocom';
    protected $fillable = [
        'date', 'uid', 'agent_name', 'state', 'duration',
        'avg_statetime', 'state_ratio', 'total_duration', 'tid'
    ];

    public function user() {
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }

    public function scopeReleaseRate($query) {
        return $query->where('state', 'Released');
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
