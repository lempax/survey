<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BugComments extends Model
{
    protected $table = 'bugcomments';
    protected $fillable = ['username', 'request_id', 'message', 'comment_date'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}

