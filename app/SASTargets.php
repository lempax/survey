<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SASTargets extends Model
{
    protected $table = 'sas_targets';
    protected $fillable = ['logged_by', 'departmentid', 'month', 'year', 'target'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'logged_by');
    }
    
    public function scopeDateRange($query, $start, $end) {
        return $query->whereBetween('created_at', [$start, $end]);
    }

    public function scopeWeekly($query, $week = false) {
        $yearweek = $week ? date('oW') - (date('W') - $week) : date('oW');
        return $query->where(\DB::raw('YEARWEEK(date,1)'), '=', $yearweek);
    }

}
