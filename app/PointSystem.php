<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PointSystem extends Model
{
    protected $table = 'pointsystem';
    protected $fillable = ['personid', 'crr', 'nps', 'aht', 'sas', 'agentposfb','nolate','noabsent', 'ootd','trivia','totalpoints','created_at', 'updated_at'];
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'personid');
    }
    
    public function getInfo(){
        
        
    }
}