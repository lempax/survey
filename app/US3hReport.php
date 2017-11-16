<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class US3hReport extends Model
{
    protected $table = 'us3hreport';
    protected $fillable = ['logged_by', 'availability', 'absenteeism', 'emails', 'products', 'sas', 'attachments', 'highlights', 'lowlights'];
    protected $dates = ['date'];
    
//    public function get_availability(){
//        
//    }
}
