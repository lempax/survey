<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Debriefing extends Model
{
    protected $table = 'debriefingreports';
    protected $fillable = ['name', 'reporttype', 'category', 'shift', 'content', 'status', 'week'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
