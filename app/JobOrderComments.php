<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOrderComments extends Model
{
    protected $table = 'job_order_comments';
    protected $fillable = [
        'id', 'uid', 'comment', 'private','status'
    ];
    protected $dates = ['date'];

    public function user() {
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}