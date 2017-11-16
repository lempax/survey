<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Irform extends Model
{
    protected $guarded = ['id'];


    public function agent(){
        
        return $this->belongsTo('App\Employee', 'agentid');
    }
    
    public function sup(){
        
        return $this->belongsTo('App\Employee', 'supid');
    }
    
     public function dept(){
        
        return $this->belongsTo('App\Department', 'team');
    }
    
    public function violation()
    {
        return $this->belongsTo('App\IrformsViolation', 'type', 'type');
    }

}