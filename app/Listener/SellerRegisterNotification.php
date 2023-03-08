<?php

namespace App\Listener;

use App\Events\SellerRegister;
use App\Mail\Verification;
use App\Traits\verifyEmail;
use Illuminate\Support\Facades\Mail;

class SellerRegisterNotification
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
     * @param  \App\Events\SellerRegister  $event
     * @return void
     */
    public function handle(SellerRegister $event)
    {
        
        $token = $this->createPersonVerify('seller_verify','seller_id',$event->seller->id);

        Mail::to($event->seller->email)->send(new Verification($event->seller,'email.verify',$token));
   
    }
}
