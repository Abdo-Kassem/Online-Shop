<?php

namespace App\Listener;

use App\Events\Register;
use App\Mail\Verification;
use App\Traits\verifyEmail;
use Illuminate\Support\Facades\Mail;

class UserRegisterNotification
{
    use verifyEmail;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\Register  $event
     * @return void
     */
    public function handle(Register $event)
    {
        
        $token = $this->createPersonVerify('user_verify','user_id',$event->user->id);

        Mail::to($event->user->email)->send(new Verification($event->user,'user.email.verify',$token));
   
    }
}
