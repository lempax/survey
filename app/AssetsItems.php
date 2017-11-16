<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetsItems extends Model
{
    protected $table = 'assets_items';
    protected $fillable = ['category', 'name', 'serial', 'quantity', 'supplier', 'date_delivered', 'warranty_date', 'logged_by'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
