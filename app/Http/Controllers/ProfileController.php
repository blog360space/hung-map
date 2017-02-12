<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests;
use Exception;

class ProfileController extends Controller
{
    /**
     * Show the form for creating a change password.
     *
     * @return \Illuminate\Http\Response
     */
    public function getChangePassword()
    {
        return view('admin.profiles.changepassword', []);
    }

    /**
     * Update a edited password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postChangePassword(Request $request)
    {
        try {
            $this->validate($request, [
                'password_old' => 'required'
            ]);

            $this->validate($request, [
                'password_new' => 'required'
            ]);

            $this->validate($request, [
                'password_re' => 'required'
            ]);
            $loginUser = $request->user();    

            if  (! Hash::check($request->password_old, $loginUser->password)) {
                throw new Exception('Password not match.');
            }
            
            if ($request->password_new != $request->password_re) {
                throw new Exception('Password confirm is not correct.');
            }
            
            $loginUser->password = bcrypt($request->password_new);
            $loginUser->save();
            
            $request->session()->flash('successMessage', 'Password update successfully.');            
        } catch (Exception $ex) {
            $request->session()->flash('errorMessage', $ex->getMessage());
        }
        
        return redirect('/profiles/change-password');
    }
}
