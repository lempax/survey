<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PDF_file extends Model
{
    protected $table = 'pdf_file';
    protected $fillable = ['pdf_id','pdf_name', 'pdf_title', 'uploader', 'type', 'date_uploaded'];
    protected $dates = ['date'];
    protected $primaryKey = 'pdf_id';
}
