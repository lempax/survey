<?php

namespace App\Http\Controllers;

use Excel;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;

class SomReportController extends Controller {

    public function __construct() {
        $this->middleware('auth');
        if (Auth::check()) {
            $_team = Auth::user()->teams();
            if ($_team->count() == 1 && $_team->first()->departmentid = 21395000)
                $this->teams = \App\Department::where('name', 'like', 'U%')->get();
            else
                switch (Auth::user()->departmentid) {
                    case 21395000:
                        $this->teams = \App\Department::where('name', 'like', '%UK Web Hosting %')->get();
                        break;
                    case 21437605:
                        $this->teams = \App\Department::where('name', 'like', '%US Web Hosting %')->get();
                        break;
                    default:
                        $this->teams = Auth::user()->teams();
                        break;
                }

            $this->exemptions = Auth::user()->settings()->type('filtered_list')->first() ?
                    json_decode(Auth::user()->settings()->type('filtered_list')->first()->entries) : [];
        }
    }
    
    public function index(Request $request){
        
    }
    
    public function upload_sheet(){
        
    }

}
