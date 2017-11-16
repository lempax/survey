<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodMenu extends Model
{
    protected $table = 'food_menu';
    protected $guarded = ['id'];
    
    public function menuDetails() {
       return $this->hasMany('App\MenuDetails');
    }
    
    public function creator()
    {
        return $this->belongsTo('App\Employee', 'uid', 'creator');
    }
    
    
}
