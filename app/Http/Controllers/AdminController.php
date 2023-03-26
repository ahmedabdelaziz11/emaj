<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
       */
     public function index($id)
     {
         if(view()->exists($id)){
            return view($id);
         }
         else
         {
            return view('404');
         }

         return view($id);
     } 
}
