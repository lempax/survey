<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailtoPhone extends Model
{
    protected $table = 'mailtophone';
    protected $fillable = ['loggedby', 'employee_name', 'case_crr', 'date_ofcase', 'customer_reached', 'reason', 'status'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
