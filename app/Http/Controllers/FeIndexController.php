<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class FeIndexController extends Controller 
{
    public function getIndex()
    {        
        return view('frontend.index.welcome');
    }
    
    public function getAbout()
    {
        return view('frontend.index.about');
    }
    
    public function getContact()
    {
        return view('frontend.index.contact');
    }
    
    public function getPost()
    {
        return view('frontend.index.post');
    }
}
