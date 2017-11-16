<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IrisForms extends Model
{
    protected $table = 'iris_forms';
    protected $fillable = [
        'id', 'contents', 'reasons', 'department', 'next_approval','requested_by','quoted_by','date_quoted','dept_head','sga_admin','sga_manager','status'
    ];
    protected $dates = ['date'];

    public function user() {
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
