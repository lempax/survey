<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemCategories extends Model
{
    protected $table = 'item_categories';
    protected $fillable = ['category'];
    public $timestamps = false;
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
    
    public function category()
    {
        return $this->hasOne('App\FoodItems', 'cat_id', 'cid');
    }
}
