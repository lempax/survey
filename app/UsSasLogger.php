<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UsSasLogger extends Model
{
    protected $table = 'us_sasloggers';
    protected $guarded = ['id'];
    
    public function usagent(){
        
        return $this->belongsTo('App\Employee', 'agent');
    }
    
    public function dept(){
        
        return $this->belongsTo('App\Department', 'team');
    }
}
