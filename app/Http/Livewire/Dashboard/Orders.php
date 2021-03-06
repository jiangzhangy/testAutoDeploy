<?php

namespace App\Http\Livewire\Dashboard;

use Livewire\Component;

class Orders extends Component
{
    public $orders = [];
    public function mount()
    {
        if (session('userInfo')['productdetails'] !== null){
            $this->orders = json_decode(session('userInfo')['productdetails'], true);
        }
    }
    public function render()
    {
        return view('livewire.dashboard.orders');
    }
}
