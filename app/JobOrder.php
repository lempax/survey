<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobOrder extends Model
{
    protected $table = 'job_order';
    protected $fillable = ['type', 'priority', 'title', 'description', 'attachments', 'status', 'dreason', 'created_by', 'assigned_to', 'tid'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
