<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IrisFormsRemarks extends Model
{
    protected $table = 'iris_forms_remarks';
    protected $fillable = [
        'iris_id', 'changed_by', 'remarks', 'visibility'
    ];
    protected $dates = ['date'];

    public function user() {
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
