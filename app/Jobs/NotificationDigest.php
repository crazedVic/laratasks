<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\NotificationDigest as Digest;

class NotificationDigest implements ShouldQueue 
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        error_log('handling notification digest');
        //check all users
        foreach (User::all() as $user)
        {
            //user has unread notifications
            if ($user->notifications()->whereNull('read_at')->count() > 0)
            {
                error_log('notifying');
                $user->notify(new Digest($user));
            }
        }
    }
}