<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOrderHistory extends Model
{
    protected $table = 'job_order_history';
    protected $fillable = ['id', 'uid', 'details'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
