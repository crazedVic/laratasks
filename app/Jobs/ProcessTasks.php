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

use function GuzzleHttp\Promise\all;

class ProcessTasks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    //models to process
    public $modelClasses = ['App\Models\Task', 'App\Models\User'];

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
        //loop through model classes
        foreach ($this->modelClasses as $class)
        {
            //verify that class implements correct trait
            if (in_array('App\Traits\HasProcess', class_uses($class)))
                $class::process();
            else
                error_log('Class \'' . $class . ' does not implement HasProcess');
        }
    }
}
