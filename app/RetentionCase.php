<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetentionCase extends Model
{
    protected $table = 'retentioncase';
    protected $fillable = ['loggedby', 'customer_id', 'contract_id', 'email_address','date','current_price','price_offered','status'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}