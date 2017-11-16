<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuDetails extends Model
{
   protected $table = 'foodmenu_details';
   protected $guarded = ['id']; 
  public function menu()
   {
       return $this->belongsTo('App\FoodMenu', 'm_id', 'menu_id');
   }
   
   public function items()
   {
       $this->hasMany('App\FoodItems', 'item_id', 'id'); 
   }
}
