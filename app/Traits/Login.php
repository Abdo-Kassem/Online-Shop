<?php

namespace App\Traits;


trait Login{

    public function log_in(array $credential,$remember = false)
    {
        $redirect = $this->redirectTo();
        
        if($this->guard()->attempt($credential,$remember)){

            session()->regenerate();
            return $redirect;
        
        }else{
            return redirect()->route($this->loginRoute);
        }
    }

}