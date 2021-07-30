<?php

namespace App\Http\Livewire;

use App\Mail\NotificationMail;
use App\Models\Task;
use App\Notifications\TaskExpiring;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Index extends Component
{
    //task values
    public $date;
    public $message;

    public $output = "";

    public $rules = 
    [
        'date' => 'required',
        'message' => 'required'
    ];

    public function mount()
    {
        //automatically login user
        \Auth::loginUsingId(1);
    }  
    
    public function render()
    {
        return view('livewire.index');
    }

    public function testQueue()
    {
        error_log('testing queue');
    }

    //tests sending an email through the queue
    public function testMail()
    {
        error_log('testing mail');

        \Auth::user()->notify(new TaskExpiring);

        $this->display('message sent successfully');
    }

    //adds a task to the db
    public function addTask()
    {
        $this->validate();

        $task = new Task(['message' => $this->message, 'date' => $this->date]);

        $task->save();

        $this->display('added task');
    }

    //formats output for display
    public function display($text)
    {
        $this->output .= '||' . $text;
    }
}
