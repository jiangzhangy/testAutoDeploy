<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\RequestApi;
use Livewire\Component;

class Account extends Component
{
    public $userInfo;

    public function mount()
    {
        $client = new RequestApi();
        $res = $client->getUserInfo();
        $this->userInfo = json_decode($res->getBody()->getContents(), true)['data'];
        session(['userInfo' => $this->userInfo]);
    }
    public function render()
    {
        return view('livewire.dashboard.account');
    }
}
