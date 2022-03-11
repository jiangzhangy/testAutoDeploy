<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\RequestApi;
use Livewire\Component;

class Account extends Component
{
    public $userInfo;

    public function mount()
    {
        $this->userInfo =  session('userInfo');
    }
    public function render()
    {
        return view('livewire.dashboard.account');
    }
}
