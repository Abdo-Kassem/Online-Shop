<?php

namespace App\Traits;

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

Trait ResetsPasswords{

    public function resetPassword(Request $request) 
    {

        return $this->broker()->reset($request->except('_token'),function($user,$password){

            $user->forceFill(['password'=>Hash::make($password)]);
            event(new PasswordReset($user));
        });

    }


}