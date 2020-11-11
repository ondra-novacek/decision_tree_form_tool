<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // public function index()
    // {
    //     return [123];
    // }


    public function getLoggedUser(Request $request) 
    {
        // dump($request->user('api'));
        // dump(Auth::id());
        return Auth::user();
        // return Auth::id();
        // return $request;
        // return Auth::check() ? Auth::user() : null;
    }
}
