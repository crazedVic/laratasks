<?php

namespace App\Processors;

use App\Models\Process;
use App\Models\Task;
use Carbon\Carbon;

class RecurringTaskProcessor
{
    protected static $process; //holder for the current process

    public static $days = ['Sunday','Monday','Tuesday',
             'Wednesday','Thursday','Friday','Saturday']; //lookup for days

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
        $next_run = Carbon::parse(static::$process->last_run) //NOTE: PUT A TIME IN HERE FOR REPEATING 
                                                              //(ex. addMinute() for a minute frequency)
        ;

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

        foreach(Task::where('current', true)->get() as $task) //TODO: orWhere('status', 'Pending') ?
        {         
            
            //TODO: remove debug
            $task->created_at = Carbon::now()->subWeek();
            $task->save();

            //determine if task needs to be copied
            switch ($task->frequency)
            {
                case 'weekly':
                    //get day that new task needs to be completed
                    $copyDay = Carbon::parse($task->created_at)->modify(static::$days[$task->day] . ' next week');

                    //ready for new task
                    if ($copyDay->isPast())
                    {   
                        //make a new task
                        $newTask = $task->replicate();
                        $newTask->current = true;

                        //set title
                        $newTask->title .= ' Week ending: ' . Carbon::parse("next friday");
                        
                        $newTask->save();

                        //deactivate old task
                        $task->current = false;
                        $task->save();
                    }
                    break;
                case 'bi-weekly':

                    //get day that new task needs to be completed
                    $copyDay = Carbon::parse($task->created_at)
                        ->modify(static::$days[$task->day] . ' next week')
                        ->addWeek();

                    //ready for new task
                    if ($copyDay->isPast())
                    {   
                        //make a new task
                        $newTask = $task->replicate();
                        $newTask->current = true;

                        //set title
                        $newTask->title .= ' Week ending: ' . Carbon::parse("next friday")->addWeek();

                        $newTask->save();

                        //deactivate old task
                        $task->current = false;
                        $task->save();
                    }
                    break;

                case 'monthly':
                    //get day that new task needs to be completed
                    $copyDay = Carbon::parse($task->created_at)
                        ->addMonth();

                    //ready for new task
                    if ($copyDay->isPast())
                    {   
                        //make a new task
                        $newTask = $task->replicate();
                        $newTask->current = true;

                        //set title
                        $newTask->title .=  ' ' .now()->month() . ' ' . now()->year();

                        $newTask->save();

                        //deactivate old task
                        $task->current = false;
                        $task->save();
                    }
                    break;

                case 'quarterly':
                    //get day that new task needs to be completed
                    $copyDay = Carbon::parse($task->created_at)
                        ->addQuarter();

                    //ready for new task
                    if ($copyDay->isPast())
                    {   
                        //make a new task
                        $newTask = $task->replicate();
                        $newTask->current = true;

                        //set title
                        $newTask->title .= ' Q' . Carbon::now()->quarter . ' ' . now()->year();

                        $newTask->save();

                        //deactivate old task
                        $task->current = false;
                        $task->save();
                    }
                    break;
            }
        }

        //----------------------------------------------------------------------
        //run finalizing code
        static::afterRun();
    }
}
