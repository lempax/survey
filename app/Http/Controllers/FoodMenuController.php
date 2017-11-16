<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class FoodMenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        if(\Auth::check() == null)
        {
            return redirect('login');
        }
    }
    
    public function index()
    {
        $page_title = 'Cafeteria Tool';
        
        return view('tools.cafeteria', compact('page_title'));
    }

}
