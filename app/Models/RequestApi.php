<?php

namespace App\Models;

use GuzzleHttp\Client;

class RequestApi
{
    private $client;
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('remote.api_host'),
        ]);
    }

    /**
     * 获取微信扫码登录地址
     * @return false|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function accessWeichatLoginUrl()
    {
        try
        {
            return $this->client->request('GET', config('remote.request_weichat_scan_login_uri'));
        }catch (\Exception $exception){
            return false;
        }
    }

    /**
     * 发送验证码
     * @param $mobile
     * @return false|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendMobileCode($mobile)
    {
        try
        {
            return $this->client->request('POST', config('remote.send_mobile_code_uri'), ['query' => ['phone' => $mobile]]);
        }catch (\Exception $exception){
            return false;
        }
    }

    public function phoneLogin($mobile, $code)
    {
        $body = json_encode(['account' => $mobile, 'code' => $code]);
        try
        {
            return $this->client->request('POST', config('remote.phone_login_uri'), ['headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'], 'body' => $body]);
        }catch (\Exception $exception){
            dd($exception->getMessage());
            return false;
        }
    }
}