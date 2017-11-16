<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    /**
     * The primary key for the Picture model.
     *
     * @var string
     */
    protected $primaryKey = 'uid';

    /**
     * Indicates if the UID are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    
    public function employee() {
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
}
