<?php

namespace App\Http\Livewire;

use App\Mail\NotificationMail;
use App\Models\Note;
use App\Models\Notification as ModelsNotification;
use App\Models\Task;
use App\Notifications\TaskExpiring;
use Carbon\Carbon;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Index extends Component
{
    //task values
    public $frequency;
    public $day;
    public $title;

    //note value
    public $note;

    //notification values
    public $notification_count;

    public $output = "";

    public $rules = 
    [
        'title' => 'sometimes|required',
        'frequency' => 'sometimes|required',
        'day' => 'sometimes|required|min:0|max:29',
        'note' => 'sometimes|required'
    ];
    public $validationAttributes = [
        'title' => 'task'
    ];

    public function mount()
    {
        //automatically login user
        //\Auth::loginUsingId(1);

        if (\Auth::check())
            $this->notification_count = \Auth::user()->notifications()->count();
        else
            redirect()->route('login');
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


    //makes a recurring task
    public function addTask()
    {
        $this->validate();

        $task = new Task([
            'title' => $this->title, 
            'day' => $this->day,
            'frequency' => $this->frequency
        ]);

        //disable task recurrance
        if ($this->frequency == 'none')
            $task->current = false;

        $task->save();
    
        $this->display('added task');
    }

    //adds a note to the db
    public function addNote()
    {
        //$this->validate();
        $note = new Note(['note' => $this->note]);
        $note->author = \Auth::user()->name;
        \Auth::user()->notes()->save($note);

        $this->display('added note');
    }

    //used to test carbon functions on click
    public function carbonTest()
    {
        $val = 'null';
        $this->display($val);

        $this->display(Carbon::parse($val));
    }

    //formats output for display
    public function display($text)
    {
        $this->output .= '||' . $text;
    }
}
