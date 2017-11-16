<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionPlan extends Model
{
    protected $table = 'action_plans';
    
    protected $guarded = ['id'];
    
    public function coachingForm()
    {
        return $this->belongsTo('App\CoachingForm','coachingform_id','id');
    }
}
