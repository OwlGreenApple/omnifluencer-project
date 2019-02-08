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
              ->with('tentang',false)
              ->with('earnings',false)
              ->with('disclaimer',false)
              ->with('syarat',false);
    }

    public function index_statics_page($page){

      switch($page) {
        case 'terms-conditions' :
          return view('statics')
              ->with('tentang',false)
              ->with('earnings',false)
              ->with('disclaimer',false)
              ->with('syarat',true); 
        break;
        case 'about-us':
          return view('statics')
              ->with('tentang',true)
              ->with('earnings',false)
              ->with('disclaimer',false)
              ->with('syarat',false); 
        break;
        case 'earnings-disclaimer':
          return view('statics')
              ->with('tentang',false)
              ->with('earnings',true)
              ->with('disclaimer',false)
              ->with('syarat',false); 
        break;
        case 'disclaimer':
          return view('statics')
              ->with('tentang',false)
              ->with('earnings',false)
              ->with('disclaimer',true)
              ->with('syarat',false); 
        break;
      }
    }
}
