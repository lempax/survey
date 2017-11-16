<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CCTVRequestComments extends Model
{
    protected $table = 'cctv_request_comments';
    
    protected $fillable = ['requests_id','employee_id','comment'];
    
    public function request()
    {
        return $this->belongsTo('App\CCTVRequests', 'requests_id');
    }
    
    public function employee()
    {
        return $this->belongsTo('App\Employee');
    }
}
