<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\PaymentSystemApi;
use GuzzleHttp\Client;
use Livewire\Component;

class Products extends Component
{
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

    public function goPay($id, $payMethod)
    {
        return '{
	"code": 200,
	"msg": "成功!",
	"data": {
		"out_trade_no": "2022031419234172016968151",
		"content": "weixin://wxpay/bizpayurl?pr=eunJ0Rqzz",
		"pay_method": 2
	}
}';
        $client = new PaymentSystemApi();
        $res = $client->createOrder(1,2);
        if (!$res){
            return json_encode([
                'code' => 500,
                'msg'   => 'error',
                'data' => '',
            ]);
        }
        return $res->getBody()->getContents();
    }
}
