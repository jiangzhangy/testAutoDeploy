<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\PaymentSystemApi;
use GuzzleHttp\Client;
use Livewire\Component;

class Products extends Component
{
    public $orderNumbers = ['2021090216163043779289161'];
    public function render()
    {
        return view('livewire.dashboard.products');
    }

    public function getProductInfo($id)
    {
       $data = [
           1 => [
               'icon' => '图片地址',
               'name' => '傲梅轻松备份',
               'subscribe' => 'VIP 终身版',
               'orderNo' => '1115555226',
               'orderCreateDate' => '2022-4-21',
               'devicesNum' => 5,
               'expiryData' => '终身'
           ],
           2 => [
               'name' => 'name2',
           ],
       ];

       return json_encode($data[$id]);
    }

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
}
