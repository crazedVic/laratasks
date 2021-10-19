<?php

namespace App\Processors;

use App\Models\Process;
use App\Models\Task;
use App\Notifications\TaskExpiring;
use Carbon\Carbon;

class TaskExpiringProcessor
{
    protected static $process; //holder for the current process

    /**
     * Helper function to prepare for run()
     * Checks if allowed to run
     */
    private static function beforeRun()
    {
        static::$process = Process::where('name', __CLASS__)->first();

        //create process if doesn't exist
        if (!static::$process)
        {
            $process = new Process([
                'name' => __CLASS__,
                'last_run' => Carbon::createFromTimestamp(0)->toDateString(), //put in past to run first
                'active' => true
            ]);

            $process->save();
            
            static::$process = $process;
        }

        //get time for next run process
        $next_run = Carbon::parse(static::$process->last_run)->addHour();

        //don't run if not time
        if (!static::$process->active || !$next_run->isPast()) return false;
        else return true;
    }

    /**
     * Helper function to finish run()
     */
    private static function afterRun()
    {
        static::$process->last_run = Carbon::now();
        static::$process->save();
    }

    /**
     * Processing to run
     */
    public static function run()
    {   
        //prepare for run
        if (!static::beforeRun()) return;
        //----------------------------------------------------------------------

        //loop through expiring tasks
        foreach (Task::where('status', 'Draft')->where('updated_at', '<', now()->addHours(env('TASK_EXPIRY_WARNING')))->get() as $task)
        {
            $task->user->notify(new TaskExpiring($task, $task->user));
        }

        //----------------------------------------------------------------------
        //run finalizing code
        static::afterRun();
    }
}
