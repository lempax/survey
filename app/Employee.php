<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{

    /**
     * The primary key for the Employee Model.
     *
     * @var string
     */
    protected $primaryKey = 'uid';
    
    protected $dates = ['bdate', 'hiredate'];

    /**
     * Indicates if the UIDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes excluded from the Employee model's JSON form.
     *
     * @var array
     */
    //protected $hidden = ['password'];

    public function position() {
        return $this->hasOne('App\Position', 'uid', 'uid');
    }

    public function department() {
        return $this->hasOne('App\Department', 'departmentid', 'departmentid');
    }

    public function teams() {
        $tt = collect();
        foreach ($this->hasMany('App\Department', 'admin', 'uid')->get() as $teams) {
            $tt->push($teams);
            foreach ($teams->members->whereIn('roles',['MANAGER','SOM','SUPERVISOR'])->get() as $sups) {
                foreach ($sups->hasMany('App\Department', 'admin', 'uid')->get() as $_teams) {
                    $tt->push($_teams);
                }
            }
        }
        return $tt;
    }

    public function settings() {
        return $this->hasMany('App\Settings', 'uid', 'uid');
    }

    public function cases() {
        return $this->hasMany('App\SSECase', 'uid', 'uid');
    }

    public function feedbacks() {
        return $this->hasMany('App\QFBReturns', 'uid', 'uid');
    }

    public function upsells() {
        return $this->hasMany('App\SASUpsells', 'person_id', 'uid');
    }
    
    public function payouts(){
        return $this->hasMany('App\Saspayout', 'person_id', 'uid');
    }
    
    public function payoutbreakdown(){
        return $this->hasMany('App\SasPayoutBreakdown', 'uid', 'uid');
    }

    public function cosmocom() {
        return $this->hasMany('App\Cosmocom', 'uid', 'uid');
    }
    
    public function cosmocalls(){
        return $this->hasMany('App\CosmoCalls', 'uid', 'uid');
    }
    
    public function logged_cases(){
        return $this->hasMany('App\LoggedCases', 'uid', 'uid');
    }
    
    public function stat_reports(){
        return $this->hasMany('App\AgentStats', 'uid', 'uid');
    }
    
    public function getImageAttribute() {
        $image = \DB::table('pictures')->where('uid', $this->uid)->first();
        return isset($image->picture) ? $image->picture :
                file_get_contents(storage_path() . '/default-avatar.jpg');
    }

    public function getSignatureAttribute() {
        $signature = \DB::table('signatures')->where('uid', $this->uid)->first();
        return base64_decode($signature->image);
    }

    public function getSuperiorAttribute() {
        return $this->department->head;
    }

    public function subordinates() {
        $subs = collect();
        foreach ($this->hasMany('App\Department', 'admin', 'uid')->get() as $teams) {
            foreach ($teams->members->get() as $mem) {
                $subs->push($mem);
            }
        }
        return $subs;
    }

    public function getNameAttribute() {
        return ucfirst($this->attributes['fname'] . ' ' . $this->attributes['lname']);
    }

    public function getLFNameAttribute() {
        return ucfirst($this->attributes['lname'] . ', ' . $this->attributes['fname']);
    }

    public function getRolesAttribute() {
        return strtoupper($this->attributes['roles']);
    }

    /**
     * Scope a query to only include active users.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query) {
        return $query->where('active', 1);
    }

    public function scopeInActive($query) {
        return $query->where('active', 0);
    }

}