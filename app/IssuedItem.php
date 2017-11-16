<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IssuedItem extends Model
{
    protected $table = 'issueditem';
    protected $fillable = ['issued_id', 'item_id', 'quantity', 'serial'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
