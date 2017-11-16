<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetsSerials extends Model
{
    protected $table = 'assets_serials';
    protected $fillable = ['item_id', 'serial', 'status'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
