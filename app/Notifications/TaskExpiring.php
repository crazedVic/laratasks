<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskExpiring extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance
     *
     * @return void
     */
    public function __construct()
    {
        error_log('construct');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {   
        //notifiable is typically the user so:
        //if notifiable prefers SMS is possible here
        return ['mail', 'database']; //add sms here 'nexmo'
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');
        return (new MailMessage)->markdown('emails.notify', [
            'message_text' => 'Superb',
            'url' => '/'
        ]);
    }

    /**
     * Get the array representation of the notification.
     *  (for database saving particularily)
     * 
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
