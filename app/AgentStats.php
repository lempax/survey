<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentStats extends Model
{
    public $table = 'agent_stats';
    public $fillable = ['rid', 'sid', 'type', 'desc', 'uid'];
    
    public function user() {
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
    
    public function scopeStackRank($query){
        return $query->where('type', 'sr');
    }
    
    public function scopeCqn($query){
        return $query->where('type', 'cqn');
    }
    
    public function scopeProd($query){
        return $query->where('type', 'pr');
    }
    
    public function scopeSas($query){
        return $query->where('type', 'sas');
    }
    
    public function scopeReleased($query){
        return $query->where('type', 'rr');
    }
    
    public function scopeAht($query){
        return $query->where('type', 'aht');
    }

    public function scopeDateRange($query, $start, $end) {
        return $query->whereBetween('created_at', [$start, $end]);
    }

    public function scopeWeekly($query, $week = false) {
        $yearweek = $week ? date('oW') - (date('W') - $week) : date('oW');
        return $query->where(\DB::raw('YEARWEEK(created_at,1)'), '=', $yearweek);
    }
}
