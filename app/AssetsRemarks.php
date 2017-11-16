<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetsRemarks extends Model
{
    protected $table = 'assets_remarks';
    protected $fillable = ['remarks_id', 'remarks_by', 'remarks'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
