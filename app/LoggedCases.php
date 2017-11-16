<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoggedCases extends Model {

    protected $table = 'loggedcases';
    protected $fillable = ['uid', 'total', 'content'];
    protected $dates = ['date'];

    public function user() {
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }

    public function scopeDateRange($query, $start, $end) {
        return $query->whereBetween('created_at', [$start, $end]);
    }

    public function scopeWeekly($query, $week = false) {
        $yearweek = $week ? date('oW') - (date('W') - $week) : date('oW');
        return $query->where(\DB::raw('YEARWEEK(date,1)'), '=', $yearweek);
    }

}
