<?php

namespace App\Notifications;

use Carbon\Carbon;
use App\Models\User;
use App\Traits\Logging;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificationDigest extends Notification implements ShouldQueue
{
    use Queueable;
    use Logging;

    protected string $message; //message to send

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //generate notification summary
        $message = "These notifications are unread:<ul>";
        foreach ($user->notifications as $notification)
        {
            $message .= "<li>" . json_decode($notification->data)->message . "</li>";
        }

        $this->message = $message;
        $this->logNotification($this->message, $user, Carbon::now());
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        //no database saving here
        return ['mail']; //TODO: add sms
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
            'button_text' => 'See Notifications'
        ]);
    }

    /**
     * Get the array representation of the notification.
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
