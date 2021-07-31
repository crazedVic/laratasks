<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskExpiring extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task; //task that is expiring

    /**
     * Create a new notification instance
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
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
            'message_text' => 'Your task \'' . $this->task->message 
                                . '\' is expiring within 24h, please complete it.',
            'button_url' => '/',
            'button_text' => 'Complete Task'
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
