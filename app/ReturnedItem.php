<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnedItem extends Model
{
    protected $table = 'returneditem';
    protected $fillable = ['cid', 'item_id', 'manufacturer', 'serial', 'condition', 'warranty', 'fixed', 'disposed', 'quantity', 'username', 'logged_by', 'date'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
    
    public static function getItemsFromCategories($cid) {
        return ItemInventory::where('cid', '=', $cid )->get();
    }
    
    public static function getSerialsFromItems($item_id) {
        return ItemSerials::where('item_id', '=', $item_id)->get();
    }
}