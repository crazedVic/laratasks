<?php

namespace App\Http\Livewire;

use App\Mail\NotificationMail;
use App\Models\Task;
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

    }
    
    public function render()
    {
        return view('livewire.index');
    }

    public function testQueue()
    {
        error_log('testing queue');
    }

    public function testMail()
    {
        error_log('testing mail');

        Mail::to("test@test.com")->send(new NotificationMail);

        $this->display('message sent successfully');
    }

    public function addTask()
    {
        $this->validate();

        $task = new Task(['message' => $this->message, 'date' => $this->date]);

        $task->save();

        $this->display('added task');
    }

    public function display($text)
    {
        $this->output .= '||' . $text;
    }
}
