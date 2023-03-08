<?php

namespace App\Traits;

use Illuminate\Http\Request;

Trait SendPasswordResetEmail{

    public function sendPasswordReset(Request $request) :string
    {
        
        return $this->broker()->sendResetLink($request->only('email'));

    }


}