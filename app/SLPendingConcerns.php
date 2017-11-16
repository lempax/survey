<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SLPendingConcerns extends Model
{
    protected $table = 'slpendingconcerns';
    protected $fillable = [
        'emp_name', 'subject', 'date', 'status', 'concern'
    ];
    protected $dates = ['date'];

    public function user() {
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
