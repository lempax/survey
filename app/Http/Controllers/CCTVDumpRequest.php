<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CCTVDumpRequest extends Controller
{
    public function createForm()
    {
        return view('cctv_requests.request_form');
    }
    
    public function listRequests()
    {
        return view('cctv_requests.request_list');
    }
}
