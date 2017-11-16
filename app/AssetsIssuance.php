<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetsIssuance extends Model
{
    protected $table = 'assets_issuance';
    protected $fillable = ['issued_id', 'issued_by', 'issued_to', 'department', 'purpose', 'date_issued', 'prepared_by', 'approved_by', 'status', 'remarks'];
    protected $dates = ['date'];
    
    public function user(){
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    }
    
    public static function getFromEmployees($department) {
        return Employee::where('departmentid', '=', $department)->get();
    }
}