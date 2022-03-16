<?php

namespace App\Models;

use GuzzleHttp\Client;

class PaymentSystemApi
{
    private $client;
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('remote.api_pay_host'),
        ]);
    }

    public function createOrder($id, $payMethod)
    {
        $userInfo = session('userInfo');
        // 轻松备份个人版
        $body = [];
        if ($id === 1){
            $body['soft_sku_id'] = 9;
            $body['quantity'] = 1;
            $body['nickname'] = $userInfo['nickname'];
            $body['mobile'] = $userInfo['account'];
            $body['email'] = '649768017@qq.com';
            $body['landing_page'] = 'https://www.abackup.com/dashboard.html';
            $body['purchase_page'] = 'https://www.abackup.com/dashboard.html';
            $body['pay_method'] = $payMethod;
        }
        try
        {
            return $this->client->request('POST', config('remote.get_order_qr_uri'), [
                'form_params' => $body,
            ]);
        }catch (\Exception $exception){
            return false;
        }
    }
}