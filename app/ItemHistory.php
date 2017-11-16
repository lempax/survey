<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemHistory extends Model
{
    protected $table = 'item_history';
    protected $fillable = ['item_id', 'history_type', 'description', 'changed_by'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
