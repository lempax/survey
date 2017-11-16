<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SupervisoryCalls extends Model
{
    protected $table = 'supervisorycalls';
    protected $fillable = ['case_number', 'requested_by', 'team', 'agent_name', 'case_date'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
    
    public static function getFromEmployees($team) {
        return Employee::where('departmentid', '=', $team )->get();
    }
}
