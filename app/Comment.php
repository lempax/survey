<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = ['id'];
    
    public function coachingForm()
    {
        return $this->belongsTo('App\CoachingForm','coachingform_id');
    }
    public function createdBy()
    {
        return $this->belongsTo('App\Employee','uid');
    }
}
