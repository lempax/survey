<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CCTVRequests extends Model
{
    protected $table = 'cctv_requests';
    protected $fillable = ['employee_id','coverage_start','coverage_end'];
    
    public function requestor()
    {
        return $this->belongsTo('App\Employee');
    }
    
    public function getStatusAttribute()
    {
        switch($this->attributes['status']) {
            case 0:
                return 'No Data Available';
            case 1:
                return 'For Superior Approval';
            case 2:
                return 'For IT Approval';
            case -1:
                return 'Declined';
        }
    }
    
    public function getDownloadLinkAttribute()
    {
        return !is_null($this->attributes['download_link']) ? 
            $this->attributes['download_link'] : 'N/A';
    }
}
