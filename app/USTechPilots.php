<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class USTechPilots extends Model
{
    protected $table = 'ustechpilots';
    protected $fillable = ['pilot'];
    protected $dates = ['date'];
}
