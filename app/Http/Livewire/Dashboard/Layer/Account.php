<?php

namespace App\Http\Livewire\Dashboard\Layer;

use App\Models\RequestApi;
use Livewire\Component;

class Account extends Component
{
    public $nickName = '';
    public $QRUrl;

    public function mount()
    {
        $client = new RequestApi();
        $res = $client->phoneBoundWechat();
        $this->QRUrl = json_decode($res->getBody()->getContents(), true)['data'];
    }
    public function render()
    {
        return view('livewire.dashboard.layer.account');
    }

    public function editName()
    {
        $client = new RequestApi();
        $res = $client->updateUsername($this->nickName);
        if (!$res){
            return 100;
        }
        if (json_decode($res->getBody()->getContents(), true)['status'] !== 0){
            return 200;
        }
        $res = $client->getUserInfo();
        $this->userInfo = json_decode($res->getBody()->getContents(), true)['data'];
        session(['userInfo' => $this->userInfo]);
        return redirect()->route('dashboard-account');
    }

    /*public function getBoundWechatQR()
    {
        $client = new RequestApi();
    }*/
}
