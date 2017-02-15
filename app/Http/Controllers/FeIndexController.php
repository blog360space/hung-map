<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class FeIndexController extends Controller 
{
    public function index()
    {        
        return view('frontend.index.welcome');
    }
}
