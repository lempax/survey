<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancellationRequests extends Model
{
    protected $table = 'cancellationrequests';
    protected $fillable = ['name', 'customer_id', 'contract_id', 'email', 'product_id', 'cancellation_date', 'effective_date','reason','type', 'week'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
