<?php

namespace App\Http\Controllers;

use App\Http\Requests;
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
        
        $this->middleware('auth');
    }
    
    public  function createAccount(Request $request)
    {
        if(\Auth::user()->role_id==2){
            return redirect(route("redirect-pending"));
        }
     
        return view("public.createAccount");
        
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->role_id==2){
            return redirect(route("redirect-pending"));
        }
        return view('home');
    }
}
