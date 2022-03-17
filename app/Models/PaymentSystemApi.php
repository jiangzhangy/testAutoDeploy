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

    /**
     * 创建订单
     * @param $productId
     * @param $payMethod
     * @return false|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createOrder($productId, $payMethod)
    {
        $userInfo = session('userInfo');
        // 轻松备份个人版
        $body = [];
        $body['soft_sku_id'] = $productId;
        $body['quantity'] = 1;
        $body['nickname'] = $userInfo['nickname'];
        $body['mobile'] = $userInfo['account'];
        $body['email'] = '649768017@qq.com';
        $body['landing_page'] = 'https://www.abackup.com/dashboard.html';
        $body['purchase_page'] = 'https://www.abackup.com/dashboard.html';
        $body['pay_method'] = $payMethod;
        try
        {
            return $this->client->request('POST', config('remote.get_order_qr_uri'), [
                'form_params' => $body,
            ]);
        }catch (\Exception $exception){
            return false;
        }
    }


    public function queryOrder($orders)
    {
        $body = [
            'orders_no' => $orders
        ];
        try
        {
            return $this->client->request('POST', config('remote.get_orders_state_uri'), [
                'json' => $body,
            ]);
        }catch (\Exception $exception){
            return false;
        }
    }
}