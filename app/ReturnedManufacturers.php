<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReturnedManufacturers extends Model
{
    protected $table = 'returnedmanufacturers';
    protected $fillable = ['name', 'date', 'manufacturer_id'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}