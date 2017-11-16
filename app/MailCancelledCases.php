<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailCancelledCases extends Model
{
    protected $table = 'mailcancelledcases';
    protected $fillable = [
        'emp_name', 'custID', 'contractID', 'email', 'prodID', 'date_cancelled', 'date_effect', 'reason'];
    protected $dates = ['date'];

    public function user() {
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
} 
