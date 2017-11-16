<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QFBReturns extends Model
{

    protected $table = 'quality_tracking';
    protected $fillable = [
        'date', 'medium', 'workpool', 'product_id', 'product_desc',
        'qfb_competence', 'qfb_first_request', 'qfb_friendliness',
        'qfb_request_customer_effort_contact', 'qfb_request_resolved',
        'qfb_response', 'qfb_solution', 'qfb_netpromoter_score',
        'qfb_comment_praise', 'qfb_comment_suggestions',
        'caseid', 'uid', 'agent_name', 'team', 'department', 'tid'
    ];

    public function user() {
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }

    public function scopeCalls($query) {
        return $query->where('medium', 'Telefon');
    }

    public function scopeEmails($query) {
        return $query->where('medium', 'Mail');
    }

    public function scopeRequestSolved($query) {
        return $query->where('qfb_request_resolved', '!=', 0);
    }

    public function scopeRequestNotSolved($query) {
        return $query->where('qfb_request_resolved', '=', 0);
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
