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

    /**
     * 手机验证码登录
     * @param $mobile
     * @param $code
     * @return false|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function phoneLogin($mobile, $code)
    {
        $body = json_encode(['account' => $mobile, 'code' => $code]);
        try
        {
            return $this->client->request('POST', config('remote.phone_login_uri'), ['headers' => ['Content-Type' => 'application/json', 'Accept' => 'application/json'], 'body' => $body]);
        }catch (\Exception $exception){
            return false;
        }
    }

    /**
     * 通过微信openid 查询用户
     * @param $openid
     * @return false|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserByOpenid($openid)
    {
        try
        {
            return $this->client->request('POST', config('remote.get_user_by_openid_uri'), ['query' => ['openID' => $openid]]);
        }catch (\Exception $exception){
            return false;
        }
    }

    /**
     * 微信和电话账户绑定
     * @param $openid
     * @return false|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function boundWechatPhone($openid, $account)
    {
        try
        {
            return $this->client->request('GET', config('remote.bound_wechat_phone_uri'), [
                'query' => [
                    'openID' => $openid,
                    'account' => $account
                ]
            ]);
        }catch (\Exception $exception){
            return false;
        }
    }

    /**
     * 更新用户名
     * @param $newName
     * @return false|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateUsername($newName)
    {
        try
        {
            return $this->client->request('POST', config('remote.update_username_uri'), ['query' => ['newName' => $newName], 'headers' => ['Authorization' => 'bearer' . session('auth')['accessToken']]]);
        }catch (\Exception $exception){
            return false;
        }
    }

    /**
     * 获取用户信息
     * @return false|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getUserInfo()
    {
        try
        {
            return $this->client->request('GET', config('remote.get_user_info_uri'), ['headers' => ['Authorization' => 'bearer' . session('auth')['accessToken']]]);
        }catch (\Exception $exception){
            return false;
        }
    }

    public function phoneBoundWechat()
    {
        try
        {
            return $this->client->request('GET', config('remote.phone_bound_wechat_uri'), ['headers' => ['Authorization' => 'bearer' . session('auth')['accessToken']]]);
        }catch (\Exception $exception){
            return false;
        }
    }

    /**
     * 更新用户头像
     * @param $fileBody  内容
     * @param $fileName 文件名称
     * @param $fileSize 文件大小
     * @return false|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateAvatar($fileBody, $fileName, $fileSize)
    {
        $body = [
            "fileBody" => $fileBody,
            "fileName" => $fileName,
            "fileSize" => $fileSize
        ];
        try
        {
            return $this->client->request('POST', config('remote.update_avatar_uri'), [
                'headers' => ['Authorization' => 'bearer' . session('auth')['accessToken']],
                'json' => $body
            ]);
        }catch (\Exception $exception){
            return false;
        }
    }

    /**
     * 更换手机
     * @param $phone 新手机号
     * @param $code 验证码
     * @return false|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updatePhone($phone, $code)
    {
        try
        {
            return $this->client->request('POST', config('remote.update_phone_uri'), [
                'headers' => ['Authorization' => 'bearer ' . session('auth')['accessToken']],
                'query' => [
                    'phone' => $phone,
                    'code'  => $code
                ]
            ]);
        }catch (\Exception $exception){
            return false;
        }
    }

    /**
     * 解除绑定设备
     * @param $device
     * @return false|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function unbindDevice($device)
    {
        try
        {
            return $this->client->request('POST', config('remote.unbind_dev'), [
                'headers' => ['Authorization' => 'bearer ' . session('auth')['accessToken']],
                'query' => [
                    'devID' => $device
                ]
            ]);
        }catch (\Exception $exception){
            return false;
        }
    }

    /**
     * 检测是否关注公众号
     * @param $scene_str
     * @return false|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function checkSubscribe($scene_str)
    {
        try
        {
            return $this->client->request('GET', config('remote.check_subscribe'), [
                'query' => [
                    'scene_str' => $scene_str
                ]
            ]);
        }catch (\Exception $exception){
            return false;
        }
    }

    public function updateUserProduct($data, $token)
    {

        try
        {
            return $this->client->request('POST', config('remote.update_user_product_uri'), [
                'headers' => ['Authorization' => 'bearer ' . $token],
                'json'  => $data
            ]);
        }catch (\Exception $exception){
            return false;
        }
    }
}