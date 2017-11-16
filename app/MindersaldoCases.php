<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MindersaldoCases extends Model
{
    protected $table = 'mindersaldocases';
    protected $fillable = ['emp_name', 'customer_id', 'contract_id', 'date_updated', 'date_mindersaldo_lock','confirm', 'week'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
