<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;

class TicketingController extends Controller {

    private $teams;
    private $exemptions;
    
    public function __construct() {
        $this->middleware('auth');
        if (Auth::check()) {
            $_team = Auth::user()->teams();
            if ($_team->count() == 1 && $_team->first()->departmentid = 21395000)
                $this->teams = \App\Department::where('name', 'like', 'U%')->get();
            else
                $this->teams = Auth::user()->teams();
            $this->exemptions = Auth::user()->settings()->type('filtered_list')->first() ?
                    json_decode(Auth::user()->settings()->type('filtered_list')->first()->entries) : [];
        }
    }
    
    public function index(){
        
    }
    
    public function create(){
        $data['page_title'] = '1&1 Ticketing Request';
        $data['page_desc'] = 'Please fill up all the required fields below to open a new ticket.';
        $data['perfurl'] = 'ticketing/create';
        $data['form_title'] = "Create Ticketing Request for " . date("F j, Y");
        return view('ticketing.create', $data);
    }
    
    public function store(){
        
    }
    
    public function display(){
        
    }

}
