<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message_text;
    public $url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($message_text, $url)
    {
        $this->message_text = $message_text;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.notify',
        [
            'message_text' => $this->message_text,
            'url' => $this->url
        ]);
    }
}
