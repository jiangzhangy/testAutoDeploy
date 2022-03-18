<?php

namespace App\Http\Livewire\Dashboard\Layer;

use App\Models\RequestApi;
use Illuminate\Support\Facades\Validator;
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

    /**
     * 修改昵称
     * @return \Illuminate\Http\RedirectResponse|int
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
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

    public function updateAvatar()
    {
        $this->validate(
            ['avatar' => 'mimes:jpg,png|max:1024'], // 1MB Max
            [
                'avatar.mimes' => ':attribute 必须是 jpg 或者 png.',
                'avatar.max' => ':attribute 大小不超过1M.',
            ],
            ['avatar' => '头像图片']
        );
        $file = $this->avatar->path(); //$file：图片地址
        if($fp = fopen($file,"rb", 0))
        {
            $gambar = fread($fp,filesize($file));
            fclose($fp);

            //获取图片base64
            $base64 = chunk_split(base64_encode($gambar));
            $client = new RequestApi();
            $res = $client->updateAvatar($base64, $this->avatar->getClientOriginalName(), $this->avatar->getMaxFilesize());
            if (!$res){
                return $this->addError('avatar', '文件上传失败');
            }
            return redirect()->route('dashboard-account');

        }
        return $this->addError('avatar', '文件上传失败');
    }

    /**
     * 发送验证码
     * @param $newPhone
     * @return \Illuminate\Support\MessageBag|string|void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendCode($newPhone)
    {
        // 验证手机号
        $validateData = Validator::make(
            ['mobile' => $newPhone],
            ['mobile' => 'required|regex:/^1[34578]\d{9}$/'],
            ['required' => '新手机号必填', 'regex' => '手机号码格式不对']
        );
        if ($validateData->fails()){
            return $validateData->messages()->toJson();
        }
        // 发送验证码
        $client = new RequestApi();
        $res = $client->sendMobileCode($newPhone);
        $resArr = json_decode($res->getBody()->getContents(), true);
        if($res->getStatusCode() !== 200 && $resArr['code'] !== 0){
            return $this->addError('code', '发送失败，请重新发送');
        }
    }

    /**
     * 修改手机号
     * @param $oldPhone
     * @param $newPhone
     * @param $code
     * @return false|\Illuminate\Http\RedirectResponse|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updatePhone($oldPhone, $newPhone, $code)
    {
        if ($oldPhone !== session('userInfo')['account']){
            return json_encode([
                'status' => 404,
                'msg' => '原手机号输入错误',
                'data' => []
            ]);
        }
        if ($newPhone === ''){
            return json_encode([
                'status' => 405,
                'msg' => '手机号不能为空',
                'data' => []
            ]);
        }
        if ($code === ''){
            return json_encode([
                'status' => 406,
                'msg' => '验证码不能为空',
                'data' => []
            ]);
        }
        // 更新手机号
        $client = new RequestApi();
        $res = $client->updatePhone($newPhone, $code);
        $resArr = json_decode($res->getBody()->getContents(), true);
        if ($resArr['status'] === 13004){
            return json_encode([
                'status' => 13004,
                'msg' => '验证码输入错误',
                'data' => []
            ]);
        }
        if ($resArr['status'] === 12000){
            return json_encode([
                'status' => 12000,
                'msg' => '手机号格式不对',
                'data' => []
            ]);
        }
        if ($resArr['status'] === 14001){
            return json_encode([
                'status' => 14001,
                'msg' => '手机号已被注册，请重新输入。',
                'data' => []
            ]);
        }
        return redirect()->route('dashboard-account');
    }
    /*public function getBoundWechatQR()
    {
        $client = new RequestApi();
    }*/
}
