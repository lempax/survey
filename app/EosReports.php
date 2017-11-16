<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EosReports extends Model {

    protected $fillable = ['logged_by', 'shift', 'tickets', 'tasks', 'summary', 'status', 'deptid', 'cc','fin_impact','shift_highlight','shift_lowlight', 'challenges','start_no_tickets','end_no_tickets'];
    protected $table = 'eos';
 
   public function user(){
        return $this->belongsTo('App\Employee', 'logged_by');
    }
    
}
