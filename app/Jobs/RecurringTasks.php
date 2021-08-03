<?php

namespace App\Jobs;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecurringTasks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $days = ['Sunday','Monday','Tuesday',
             'Wednesday','Thursday','Friday','Saturday'];

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
        foreach(Task::where('current', true)->get() as $task) //TODO: orWhere('status', 'Pending') ?
        {            
            //determine if task needs to be copied
            switch ($task->frequency)
            {
                case 'weekly':
                    //get day that new task needs to be completed
                    $copyDay = Carbon::parse($task->created_at)->modify($this->days[$task->day] . ' next week');

                    //ready for new task
                    if ($copyDay->isPast())
                    {   
                        //make a new task
                        $newTask = $task->replicate();
                        $newTask->current = true;
                        $newTask->save();

                        //deactivate old task
                        $task->current = false;
                        $task->save();
                    }
                    break;
                case 'bi-weekly':

                    //get day that new task needs to be completed
                    $copyDay = Carbon::parse($task->created_at)
                        ->modify($this->days[$task->day] . ' next week')
                        ->addWeek();

                    //ready for new task
                    if ($copyDay->isPast())
                    {   
                        //make a new task
                        $newTask = $task->replicate();
                        $newTask->current = true;
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
                        $newTask->save();

                        //deactivate old task
                        $task->current = false;
                        $task->save();
                    }
                    break;
            }
        }
    }
}
