<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{

    protected $table = 'settings';
    protected $fillable = ['uid', 'type', 'entries'];

    public function user() {
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }

    public function scopeType($query, $type) {
        return $query->where('type', $type);
    }

}
