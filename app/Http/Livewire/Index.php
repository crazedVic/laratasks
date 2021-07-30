<?php

namespace App\Http\Livewire;

use App\Mail\NotificationMail;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Index extends Component
{

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


    }
}
