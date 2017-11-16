<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SSECase extends Model
{

    protected $table = 'case_tracking';
    protected $fillable = [
        'date', 'medium', 'workpool', 'tracking1', 'tracking2',
        'product_line', 'product_id', 'product_desc',
        'caseid', 'customerid', 'uid', 'agent_id', 'agent_name',
        'team', 'case_count', 'bl_count', 'tid',
        'avg_case_editing_time', 'avg_editing_time', 'avg_sas_editing_time'
    ];
    protected $dates = ['date'];

    public function user() {
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }

    public function scopeCalls($query) {
        return $query->where('medium', '=', 'Telefon');
    }

    public function scopeEmails($query) {
        return $query->where('medium', '=', 'Mail');
    }

    public function scopeMediumType($query, $type = 'Telefon') {
        return $query->where('medium', $type);
    }

    public function scopeNotBlacklisted($query) {
        return $query->where('bl_count', '=', 0);
    }

    public function scopeBlacklisted($query) {
        return $query->where('bl_count', '!=', 0);
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
