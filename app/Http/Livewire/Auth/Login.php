<?php

namespace App\Http\Livewire\Auth;

use App\Models\RequestApi;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class Login extends Component
{
    public $url = '';
    public $mobile;
    public $code;
    public $linkedAccount;
    public $sceneStr = '';

    public function render()
    {
        return view('livewire.auth.login');
    }
    // 获取登录二维码
    public function getQRCodeString(){
        $requestApi = new RequestApi();
        $res = $requestApi->accessWeichatLoginUrl();
        if ($res){
            $resArr = json_decode($res->getBody()->getContents(), true);
            $this->url = $resArr['data']['qrcode'];
            $this->sceneStr = $resArr['data']['scene_str'];
            return json_encode([
                'code' => 0,
                'qrcode' => $resArr['data']['qrcode']
            ]);
        }
        return json_encode([
            'code' => 500,
            'qrcode' => ''
        ]);
    }

    public function sendCode($mobile)
    {
        // 验证手机号
        $validateData = Validator::make(
            ['mobile' => $mobile],
            ['mobile' => 'required|regex:/^1[345789]\d{9}$/'],
            ['required' => '手机号必填', 'regex' => '手机号码格式不对']
        );
        if ($validateData->fails()){
            return $validateData->messages()->toJson();
        }
        // 发送验证码
        $client = new RequestApi();
        $res = $client->sendMobileCode($mobile);
        $resArr = json_decode($res->getBody()->getContents(), true);
        if($res->getStatusCode() !== 200 && $resArr['code'] !== 0){
            return $this->addError('code', '发送失败，请重新发送');
        }
        // 发送成功提示
        $this->mobile = $mobile;
    }

    /**
     * 手机验证码登录
     * @param $mobile
     * @param $code
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Support\MessageBag
     * @throws \Illuminate\Validation\ValidationException
     */
    public function submit($mobile, $code)
    {
        $res = $this->getUserByPhone($mobile, $code);
        if ($res !== true){
            return $res;
        }
        // 跳转到 个人中心
        return redirect()->route('dashboard');
    }

    public function bindPhone($mobile, $code)
    {
        $res = $this->getUserByPhone($mobile, $code);
        if ($res !== true){
            return $res;
        }
        // 绑定微信和手机号
        $client = new RequestApi();
        $res = $client->boundWechatPhone($this->linkedAccount, session('auth')['account']);
        if ($res === false) {
            return $this->addError('systemError', '系统异常');
        }
        $resArr = json_decode($res->getBody()->getContents(), true);
        if($res->getStatusCode() === 200 && $resArr['status'] === 16005){
            return $this->addError('reusePhone', '该手机号已经被其他账户绑定');
        }
        if($res->getStatusCode() !== 200 && $resArr['code'] !== 0){
            return $this->addError('bound', '绑定失败');
        }
        return redirect()->to('/dashboard');

    }

    protected function getUserByPhone($mobile, $code){
        // 验证手机号和验证码格式
        $validateData = Validator::make(
            ['mobile' => $mobile, 'code' => $code],
            ['mobile' => 'required|regex:/^1[345789]\d{9}$/', 'code' => 'required|numeric|digits:6'],
            [

                'mobile.regex' => '手机号码格式错误',
                'mobile.required' => '手机号码必填',
                'code.required' => '验证码必填',
                'code.numeric' => '验证码格式错误',
                'code.digits' => '验证码是6位数字'
            ]
        );
        if ($validateData->fails()){
            return $validateData->errors()->toJson();
        }
        $client = new RequestApi();
        $res = $client->phoneLogin($mobile, $code);
        if ($res === false) {
            return $this->addError('systemError', '系统异常');
        }
        $resArr = json_decode($res->getBody()->getContents(), true);
        if (isset($resArr['status']) && $resArr['status'] !== 0) {
            return $this->addError('code', '验证码输入错误');
        }
        // 存入 session
        session(['auth' => $resArr['data']]);
        return true;
    }

    public function checkSubscribe()
    {
        $client = new RequestApi();
        $res = $client->checkSubscribe($this->sceneStr);
        if($res){
            $resArr = json_decode($res->getBody()->getContents(), true);
            if ($resArr['status'] === 0){
                // 检测是否绑定手机账户
                $data = json_decode($resArr['data'], true);
                return redirect()->to('login?openid=' . $data['openid']);
            }
        }
    }
}
