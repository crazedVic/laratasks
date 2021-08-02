<?php

namespace App\Notifications;

use App\Models\Task;
use App\Models\User;
use App\Traits\Logging;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TaskExpiring extends Notification implements ShouldQueue
{
    use Queueable;
    use Logging;

    protected $task; //task that is expiring
    protected string $message; //message to send out
    protected $time;
    protected User $user;

    /**
     * Create a new notification instance
     *
     * @return void
     */
    public function __construct(Task $task, User $user)
    {
        $this->task = $task;

        $this->message = 'Your task \'' . $this->task->message 
                                . '\' is expiring within 24h, please complete it.';
        $this->time = Carbon::now();
        $this->user = $user;

        $this->logNotification($this->message, $this->user, $this->time);
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
        return (new MailMessage)->markdown('emails.notify', [
            'message_text' => $this->message,
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
            'time' => $this->time,
            'message' => $this->message,
            'user' => $this->user
        ];
    }
}
