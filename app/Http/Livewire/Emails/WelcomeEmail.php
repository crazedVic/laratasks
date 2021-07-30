<?php

namespace App\Http\Livewire\Emails;

use Livewire\Component;

class WelcomeEmail extends Component
{
    public function render()
    {
        return view('livewire.emails.welcome-email');
    }
}
