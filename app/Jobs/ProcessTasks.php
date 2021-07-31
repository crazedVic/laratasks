<?php

namespace App\Jobs;

use App\Models\Task;
use App\Notifications\TaskExpiring;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTasks implements ShouldQueue
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
        error_log('handling');
        foreach (Task::all() as $task)
        {
            if ($task->date < now()->addHours(48))
            {
                $task->user->notify(new TaskExpiring);
            }
        }
    }
}
