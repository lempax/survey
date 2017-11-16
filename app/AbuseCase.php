<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AbuseCase extends Model
{
    protected $table = 'abusecase';
    protected $fillable = ['employee_name', 'case_id', 'customer_id', 'contract_id', 'day_called', 'date_called','comment'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}

