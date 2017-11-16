<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailSAS extends Model
{
    protected $table = 'mailsas';
    protected $fillable = [
        'emp_name', 'custID', 'caseID', 'contractID', 'product_cycle', 'date_upsells', 'notes', 'order_date'];
    protected $dates = ['date'];

    public function user() {
        return $this->belongsTo('App\Employee', 'uid', 'uid');
    } 
}
