<?php

namespace App\Http\Livewire;

use App\Mail\NotificationMail;
use App\Models\Notification as ModelsNotification;
use App\Models\Task;
use App\Notifications\TaskExpiring;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Index extends Component
{
    //task values
    public $date;
    public $message;

    //notification values
    public $notification_count;

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

        $this->notification_count = \Auth::user()->notifications()->count();
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

        \Auth::user()->notify(new TaskExpiring(new Task(), \Auth::user()));

        $this->display('message sent');
    }

    //adds a task to the db
    public function addTask()
    {
        $this->validate();

        $task = new Task(['message' => $this->message, 'date' => $this->date]);
        \Auth::user()->task()->save($task);

        $this->display('added task');
    }

    //formats output for display
    public function display($text)
    {
        $this->output .= '||' . $text;
    }
}
