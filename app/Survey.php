<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
  protected $fillable = ['title', 'description', 'user_id', 'batch_no', 'respondents', 'status', 'invited', 'participants', 'team'];
  protected $dates = ['deleted_at'];
  protected $table = 'survey';

  public function questions() {
    return $this->hasMany(Question::class);
  }

  public function user() {
    return $this->belongsTo('App\Employee', 'uid');
  }
  
  public function answers() {
    return $this->hasMany(Answer::class);
  }

}
