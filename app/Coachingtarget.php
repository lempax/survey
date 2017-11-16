<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coachingtarget extends Model
{
    protected $table = 'coachingtargets';
    protected $guarded = ['id'];
    
    public function createdBy()
    {
        return $this->belongsTo('App\Employee', 'created_by');
    }
}
