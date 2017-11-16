<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoFeedback extends Model
{
    protected $table = 'nofeedbackcases';
    protected $fillable = ['team', 'agent', 'reason', 'calls', 'emails', 'actionplan', 'casedate'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
