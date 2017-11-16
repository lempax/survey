<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingOutbound extends Model
{
    protected $table = 'billing_outbound';
    protected $fillable = ['user', 'custid', 'contractid', 'case_id', 'notes', 'date','timestamp','remarks'];
    protected $guarded = ['id'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'username', 'user');
    }

}
