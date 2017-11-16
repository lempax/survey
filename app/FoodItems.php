<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodItems extends Model
{
    protected $table = 'food_items';
    
    protected $guarded = ['id'];
    
    
  public function category(){
     return $this->hasOne('App\ItemCategories', 'cid', 'cat_id');
  }
  public function nameofCat()
  {
      return $this->hasOne('App\ItemCategories');
  }
    
}

