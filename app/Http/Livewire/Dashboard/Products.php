<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\PaymentSystemApi;
use App\Models\RequestApi;
use App\Models\SerialNumber;
use Livewire\Component;

class Products extends Component
{
    public $orderNumbers = [];
    public $devDetails = [];
    public $type = '';
    public function render()
    {
        if (session('userInfo')['devicedetails'] !== null){
            $devDetailsStr = json_decode(session('userInfo')['devicedetails'], true);
            $this->devDetails = array_values($devDetailsStr);
        }
        $url = url()->current();
        $urlArr = explode('/', $url);
        $this->type = last($urlArr);
        return view('livewire.dashboard.products');
    }

    /**产品详情
     * @param $type
     * @return false|string
     */
    public function getProductInfo($type)
    {
        $productdetails = session('userInfo')['productdetails'];
        if ($productdetails !== null){
            $productdetailsArr = json_decode($productdetails, true);
        }
        $name = '';
        if (!$productdetailsArr[$type]){
            return '{}';
        }
        if ($productdetailsArr[$type]['type'] === 'AB'){
            $name = '傲梅轻松备份';
        }
        $data = [
            'name' => $name,
            'orderNo' => $productdetailsArr[$type]['paymentDetails']['orderId'],
            'orderCreateDate' => date('Y-m-d', $productdetailsArr[$type]['paymentDetails']['createTime']/1000),
            'subscribe' => $productdetailsArr[$type]['paymentDetails']['type'] === '1' ? '终身版' : '订阅',
            'devicesNum' => $productdetailsArr[$type]['paymentDetails']['devices'],
            'expiryData' => $productdetailsArr[$type]['paymentDetails']['eTime'] === '0' ? '终身' : date('Y-m-d', $productdetailsArr[$type]['paymentDetails']['eTime']/1000),
        ];
       return json_encode($data);
    }

    /**
     * 购买
     * @param $productId
     * @param $payMethod
     * @return false|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function goPay($productId, $payMethod)
    {
        $client = new PaymentSystemApi();
        $res = $client->createOrder($productId, $payMethod);
        if (!$res){
            return json_encode([
                'code' => 500,
                'msg'   => 'error',
                'data' => '',
            ]);
        }
        $data = json_decode($res->getBody()->getContents(), true);
        $this->orderNumbers[] = $data['data']['out_trade_no'];
        return json_encode($data);
    }

    /**
     * 轮询查订单
     * @return false|string
     */
    public function queryOrderState()
    {
        $client = new PaymentSystemApi();
        $res = $client->queryOrder($this->orderNumbers);
        if (!$res){
            return json_encode([
                'code' => 500,
                'msg'   => 'error',
                'data'  => []
            ]);
        }
        return $res->getBody()->getContents();
    }

    /**
     * 解除设备绑定
     * @param $devId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function unbind($devId)
    {
        $client = new RequestApi();
        $res = $client->unbindDevice($devId);
        return redirect()->route('dashboard-products');
    }

    public function bondCode($serialNumber)
    {
        // 查找序列码
        $serialNumberModel = new SerialNumber();
        $sn = $serialNumberModel->where('serial_number', $serialNumber)->first();
        if (!$sn){
            return json_encode([
                'code' => 404,
                'msg'  => '序列码不存在或者错误',
                'data' => []
            ]);
        }
        // 修改用户产品信息
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
        $str = microtime();
        $fstr =  substr($str,11,10).substr($str,2,6);
        $data = [
            'name'  => $sn->soft->soft_name,
            'newSupportVersion'  => $newVersionFormat,
            'oldSupportVersion'  => $oldVersionReturn,
            'paymentDetails'  => [
                'createTime' => $fstr,
                'devices' => (string)$sn->support_max_number,
                'etime' => '0',
                'orderId' => 'ABB'.date('YmdHis').substr(microtime(), 2, 5) . mt_rand(10000,99999),
                'status' => '1',
                'stime' => '0',
                'type' => $sn->subscribe_type_id,
            ],
            'proVersion'  => $sn->support_version,
            'regCode'  => $serialNumber,
            'type'  => $sn->soft->alias,
            'version'  => $sn->release_version,
        ];
        $res = $client->updateUserProduct($data, session('auth')['accessToken']);
        if (!$res){
            return json_encode([
                'code' => 404,
                'msg'  => '系统错误',
                'data' => []
            ]);
        }
        return redirect()->route('dashboard-products');
    }
}
