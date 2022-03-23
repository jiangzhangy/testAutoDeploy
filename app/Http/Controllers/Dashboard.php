<?php

namespace App\Http\Controllers;

use App\Models\OAuthApi;
use App\Models\RequestApi;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Dashboard extends Controller
{

    public function index()
    {
        return view('pages.dashboard.help');
    }

    public function account()
    {
        return view('pages.dashboard.account');
    }

    public function help()
    {
        return view('pages.dashboard.help');
    }

    public function products()
    {
        return view('pages.dashboard.products');
    }

    public function updateOrder(Request $request)
    {
       $productNumbers = [
        '7' => 3,
        '9' => 4,
        '10' => 5,
        '13' => 6,
        ];
        $data = $request->getContent();
        if ($data === ''){
            // 记录日志
           return false;
        }
        $data = json_decode($data, true);
        // 查询序列码相关相信，并更新账户系统对应付费产品接口
        $serialNumber = new SerialNumber();
        $sn = $serialNumber->where('serial_number', $data['data']['serial_number'])->first();
        if (!$sn){
            // 记录日志
            return false;
        }
        // 授权
        $auth = new OAuthApi();
        $info = $auth->login($data['data']['account'],$data['data']['account']);
        if (!$info){
            // 记录日志
            return false;
        }
        $tokenArr = json_decode($info->getBody()->getContents(), true);
        $token = $tokenArr['data']['accessToken'] ?? '';
        // 账户系统对应付费产品接口
        $client = new RequestApi();
        $newVersionFormatArray = explode('.',  $sn->soft->cur_version);
        $_pnum = $sn->soft_id;//该注册码所属包对应的 产品id
        $pnum = $productNumbers[$_pnum] ?? 0;//开发部要求对应的产品数字
        $regVersion = substr($sn->release_version, 0, 1) . $pnum . '0';
        if ($sn->soft->cur_version === ''){
            $newVersionFormatArray[0] = '6';
        }
        $oldVersionFormat = str_pad($regVersion, 3, "0", STR_PAD_LEFT);
        $oldVersionReturn = str_pad($newVersionFormatArray[0] . $sn->support_version, 3, "0", STR_PAD_RIGHT);
        if (count($newVersionFormatArray) === 3) {
            $newVersionFormat = '';
            foreach ($newVersionFormatArray as $value) {
                $newVersionFormat .= str_pad($value, 2, '0', STR_PAD_LEFT);
            }
        } else {
            $newVersionFormat = $oldVersionFormat;
        }
        $data = [
            'name'  => $sn->soft->soft_name,
            'newSupportVersion'  => $newVersionFormat,
            'oldSupportVersion'  => $oldVersionReturn,
            'paymentDetails'  => [
                'createTime' => $data['data']['create_time'],
                'devices' => (string)$sn->support_max_number,
                'etime' => '0',
                'orderId' => $data['data']['order_no'],
                'status' => '1',
                'stime' => '0',
                'type' => $sn->subscribe_type_id,
            ],
            'proVersion'  => $sn->support_version,
            'regCode'  => $data['data']['serial_number'],
            'type'  => $sn->soft->alias,
            'version'  => $sn->release_version,
        ];
        $res = $client->updateUserProduct($data, $token);
        if (!$res){
            // 记录日志
            return false;
        }
    }
}
