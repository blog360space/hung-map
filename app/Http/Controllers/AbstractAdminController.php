<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


abstract class  AbstractAdminController  extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
        $request = new Request;        
        if (! $request->isXmlHttpRequest()) {
            
        }
      
    }
}
