<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;
use App\Employee;
use Illuminate\Support\Facades\Input;
use Auth;


class BirthdayUploadController extends Controller {

    public function upload() {       
        $data['page_title'] = 'Birthday Card Uploader';
        $data['page_desc'] = 'Allow supervisors to upload birthday card for agents.';
        $data['perfurl'] = 'birthdaycard/upload';
        $data['subordinates'] = Auth::user()->subordinates();
        return view('birthdayuploader.upload', $data);        
    }

    public function file(Request $request) {
        $filename = $request->input('filename');
        if (Input::hasFile('import_file')) {
            echo 'Uploaded';
            $file = Input::file('import_file');
           $file->move('assets/uploadedcards', $filename.".jpg");
            echo '';           
        }       
        return back();
    }
}