<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Freemailers extends Model
{
    protected $table = 'freemailers';
    protected $fillable = ['name', 'customer_id', 'case_id', 'medium', 'email', 'description', 'week'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
