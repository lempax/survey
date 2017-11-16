<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOrderInProgress extends Model
{
    protected $table = 'job_order_inprogress';
    protected $fillable = [
        'id', 'assignee', 'date_due'
    ];
    protected $dates = ['date'];

    public function user() {
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}