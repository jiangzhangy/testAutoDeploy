<?php

namespace App\Http\Livewire\Dashboard\Layer;

use App\Models\RequestApi;
use Livewire\Component;

class Account extends Component
{
    public $nickName = '';
    public function render()
    {
        return view('livewire.dashboard.layer.account');
    }

    public function editName()
    {
        $client = new RequestApi();
        $res = $client->updateUsername($this->nickName);
        dd($res);
    }
}
