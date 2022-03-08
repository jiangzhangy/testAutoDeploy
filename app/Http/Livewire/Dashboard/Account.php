<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class Account extends Component
{
    public $user;

    public function mount()
    {
        $this->user = session('auth');
    }
    public function render()
    {
        return view('livewire.dashboard.account');
    }
}
