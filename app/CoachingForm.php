<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CoachingForm extends Model
{
    protected $table = 'coachings';
    
    protected $guarded = ['id'];
    
    
    public function comments()
    {
        return $this->hasMany('App\Comment','coachingform_id');
    }
    
    public function actionPlans()
    {
        return $this->hasMany('App\ActionPlan','coachingform_id');
    }
    
    public function agent()
    {
        return $this->belongsTo('App\Employee');
    }
    
    public function createdBy()
    {
        return $this->belongsTo('App\Employee','creator');
    }
    public function agentSuperior()
    {
        return $this->belongsTo('App\Employee', 'superior');
    }
    public function agentManager()
    {
        return $this->belongsTo('App\Employee', 'manager');
    }
}
