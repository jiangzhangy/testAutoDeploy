<?php

namespace App\Http\Livewire\Dashboard\Layer;

use App\Models\RequestApi;
use Livewire\Component;
use Livewire\WithFileUploads;

class Account extends Component
{
    use WithFileUploads;
    public $nickName = '';
    public $QRUrl;
    public $avatar;
    public $userInfo;

    public function mount()
    {
        $this->userInfo = session('userInfo');
        $client = new RequestApi();
        $res = $client->accessWeichatLoginUrl();
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

    public function saveAvatar()
    {
        
    }

    /*public function getBoundWechatQR()
    {
        $client = new RequestApi();
    }*/
}
