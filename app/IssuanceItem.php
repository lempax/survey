<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IssuanceItem extends Model
{
    protected $table = 'issuanceitem';
    protected $fillable = [
        'issued_id', 'issued_by', 'issued_to', 'attached_mris', 'attached_iris', 'department', 'purpose'
    ];
    protected $dates = ['date'];

    public function user() {
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    } 
    
    public static function getFromEmployees($department) {
        return Employee::where('departmentid', '=', $department)->get();
    }   
    
    
}