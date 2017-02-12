<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ProfileController extends Controller
{
    /**
     * Show the form for creating a change password.
     *
     * @return \Illuminate\Http\Response
     */
    public function getChangePassword()
    {
        return view('admin.profiles.changepassword', [
            
        ]);
    }

    /**
     * Update a edited password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postChangePassword(Request $request)
    {
        echo 'chay vao day';
    }
}
