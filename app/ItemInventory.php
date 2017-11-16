<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemInventory extends Model
{
    protected $table = 'items';
    protected $fillable = ['id', 'type', 'name', 'price', 'quantity', 'cid', 'supplier', 'addn_details', 'warranty_date', 'date_delivered', 'verified'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
