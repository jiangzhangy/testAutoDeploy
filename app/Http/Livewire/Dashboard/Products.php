<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\PaymentSystemApi;
use App\Models\RequestApi;
use GuzzleHttp\Client;
use Livewire\Component;

class Products extends Component
{
    public $orderNumbers = [];
    public $devDetails = [];
    public function render()
    {
        if (session('userInfo')['devicedetails'] !== null){
            $devDetailsStr = json_decode(session('userInfo')['devicedetails'], true);
            $this->devDetails = array_values($devDetailsStr);
        }
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
            'expiryData' => $productdetailsArr[$type]['paymentDetails']['eTime'] === '8888-88-88' ? '终身' : date('Y-m-d', $productdetailsArr[$type]['paymentDetails']['eTime']/1000),
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
}
