<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class US_emails extends Model
{
    protected $table = 'us_emails';
    protected $fillable = ['workpool'];
    protected $dates = ['date'];
}
