<?php

namespace App\Models;

use GuzzleHttp\Client;

class OAuthApi
{
    private $client;
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => config('remote.api_auth_host'),
        ]);
    }

    public function login($account, $pwd, $type = 1)
    {
        try
        {
            return $this->client->request('POST', config('remote.auth_user_login'), ['query' => ['username' => $account, 'password' => $pwd, 'type' => $type]]);
        }catch (\Exception $exception){
            dd($exception->getMessage());
            return false;
        }
    }
}