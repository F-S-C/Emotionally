<?php

namespace Emotionally\Http\Controllers;

use Auth;
use Emotionally\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function editProfile(Request $request)
    {
        Auth::user()->name = $request->input('name','NO_NAME');
        Auth::user()->surname=$request->input('surname','NO_SURNAME');
        if(!empty($request->input('password'))) {
            Auth::user()->password = bcrypt($request->input('password', 'NO_PASSWORD'));
        }
        Auth::user()->save();
        return redirect(route('system.profile'));
    }
}
