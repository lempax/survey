<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class BugRequest extends Model
{
    protected $table = 'bugrequest';
    protected $fillable = ['loggedby', 'category', 'subject', 'customer_id', 'contract_id', 'tech_id', 'project_id','description','solution','behavior','date_occurrence','instruction','files','browser1','browser2','os','recipient','status'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
    
//    public function markets(){
//       $markets = $this->department()->lists('market');
//       return Department::whereIn('market',$markets)->get();
//    }
//    
//    public static function members(){
//        $members = $this->markets()->lists('departmentid');
//        return Employee::whereIn('departmentid', $members)->get();
//    }
}

