<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordReset extends Mailable
{
    use Queueable, SerializesModels;


    public array $data;
    private $routeName;
    private $token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $data,$routeName,$token)
    {
        $this->data = $data;
        $this->routeName = $routeName;
        $this->token = $token;
    }

    public function changeURL($routeName){
        $this->routeName = $routeName;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from: new Address('abdelrahman@gmail.com','abdelrahman Ahmed Kassem'),
            tags:['register'],
            subject: 'Email Verification',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'resetEmail.regesteration',
            with: [
                'routeName'=>$this->routeName,
                'data'=>$this->data,
                'token'=>$this->token
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [
            
        ];
    }
}
