<?php

namespace App\Http\Controllers;

use Auth;
use Mail;
use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;

class UsReportsController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }
    
    public function index(){
        
    }
    
    public function create(){
        $page_title = 'US Weekly Reports';
        $page_desc = 'Allows US supervisors to log weekly reports';
        return view('usreports.home', compact('page_title', 'page_desc'));
    }

}