<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepairedItem extends Model
{
    protected $table = 'repaireditem';
    protected $fillable = ['date', 'name','department', 'description', 'brand', 'serial', 'defect', 'status','request_id'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
