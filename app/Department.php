<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model {

    /**
     * The primary key for the Department model.
     *
     * @var string
     */
    protected $primaryKey = 'gid';

    /**
     * Indicates if the GIDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public function head() {
        return $this->hasOne('App\Employee', 'uid', 'admin');
    }

    public function getMembersAttribute() {
        return Employee::whereIn('uid', json_decode($this->attributes['members']));
    }

    public function getDirectReportsAttribute() {
        return Employee::whereIn('uid', json_decode($this->attributes['direct_reporters']));
    }

    public function getShortNameAttribute() {
        $_str = explode(" ", $this->attributes['name']);
        return $_str[0] . ' ' . $_str[count($_str) - 2] . ' ' . $_str[count($_str) - 1];
    }

    public function cases() {
        return $this->hasManyThrough('App\SSECase', 'App\Employee', 'departmentid', 'uid', 'departmentid')
                        ->orWhere('case_tracking.uid', $this->head->uid);
    }

    public function feedbacks() {
        return $this->hasManyThrough('App\QFBReturns', 'App\Employee', 'departmentid', 'uid', 'departmentid')
                        ->orWhere('quality_tracking.uid', $this->head->uid);
    }

    public function upsells() {
        return $this->hasManyThrough('App\SASUpsells', 'App\Employee', 'departmentid', 'person_id', 'departmentid')
                        ->orWhere('sas_tracking.person_id', $this->head->uid);
    }
    
    public function payouts() {
        return $this->hasManyThrough('App\Saspayout', 'App\Employee', 'departmentid', 'person_id', 'departmentid')
                        ->orWhere('sas_payout.person_id', $this->head->uid);
    }
    
    public function payoutbreakdown() {
        return $this->hasManyThrough('App\SasPayoutBreakdown', 'App\Employee', 'departmentid', 'uid', 'departmentid')
                        ->orWhere('sas_payout_breakdown.uid', $this->head->uid);
    }

    public function cosmocom() {
        return $this->hasManyThrough('App\Cosmocom', 'App\Employee', 'departmentid', 'uid', 'departmentid');
    }
    
    public function cosmocalls() {
        return $this->hasManyThrough('App\Cosmocalls', 'App\Employee', 'departmentid', 'uid', 'departmentid');
    }
}
