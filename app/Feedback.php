<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';
    protected $fillable = ['email', 'agent', 'other_agent', 'customer_number', 'case_id', 'problem', 'solution', 'week'];
    protected $dates = ['date'];
    
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
