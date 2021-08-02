<?php

namespace App\Processors;
use App\Models\Task;
use App\Notifications\TaskExpiring;

class TaskProcessor
{
    public static function run()
    {
        //loop through expiring tasks
        foreach (Task::where('status', 'Draft')->where('updated_at', '<', now()->addHours(env('TASK_EXPIRY_WARNING')))->get() as $task)
        {
            $task->user->notify(new TaskExpiring($task, $task->user));
        }
    }
}
