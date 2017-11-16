<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model {

    /**
     * The primary key for the Department model.
     *
     * @var string
     */
    protected $primaryKey = 'uid';

    /**
     * Indicates if the GIDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    public function employee() {
        return $this->belongsTo('App\User', 'uid', 'uid');
    }
    
    public function getPositionAttribute() {
        return strtoupper($this->attributes['position']);
    }

}
