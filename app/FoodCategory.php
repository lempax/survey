<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodCategory extends Model
{
    protected $table = 'item_category';
    protected $guarded = ['id'];
    
    public function item() {
        $this->hasMany('App\Item');
    }
}
