<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function index_faq(){
      return view('faq');
    }

    public function index_statics(){
      return view('statics')
              ->with('syarat',false);
    }

    public function index_syarat_ketentuan(){
      return view('statics')
              ->with('syarat',true); 
    }
}
