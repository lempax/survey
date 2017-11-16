<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SASLowPerformersCases extends Model
{
    protected $table = 'saslowperformerscases';
    protected $fillable = [
        'team_name', 'agent_name', 'total_calls', 'reasons',
        'sup_actionplan'
    ];
    protected $dates = ['date'];

    public function user() {
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
