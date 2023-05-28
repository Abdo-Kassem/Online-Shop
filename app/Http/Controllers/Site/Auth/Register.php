<?php

namespace App\Http\Controllers\Site\Auth;

use App\Events\Register as EventsRegister;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterValidator;
use App\Models\User;
use App\Services\UserServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Register extends Controller
{

    

    public function getForm()
    {
        return view('site.auth.register');
    }

    public function register(RegisterValidator $request)
    {
        $user = (new UserServices)->store($request);

        event(new EventsRegister($user));
            
        Auth::login($user);

        return redirect()->intended();
    }

}
