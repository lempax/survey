<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MRFormsRemarks extends Model
{
    protected $table = 'mr_forms_remarks';
    protected $fillable = [
        'mr_id', 'changed_by', 'remarks', 'visibility'
    ];
    protected $dates = ['date'];

    public function user() {
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
