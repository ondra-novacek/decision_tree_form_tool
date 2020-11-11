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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.vueapp');
    }


    public function default()
    {
        return view('home.default', ['user' => 1]);
    }


    public function vueapp()
    {
        return view('home.vueapp');
    }
}
