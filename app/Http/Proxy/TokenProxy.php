<?php

namespace App\Http\Proxy;

use GuzzleHttp\Client;

class TokenProxy
{
    protected $http;

    /**
     * 注入Client
     *
     * TokenProxy constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->http = $client;
    }

    /**
     * 获取token
     *
     * @param $grandType
     * @param array $data
     * @return $this
     */
    public function getToken($grandType, array $data)
    {
        // oauth参数
        $data = array_merge($data, [
            'client_id' => config('global.passport.grant_client_id'),
            'client_secret' => config('global.passport.grant_client_secret'),
            'grant_type' => $grandType,
        ]);
        // 请求接口
        $response = $this->http->post(url('oauth/token'), [
            'form_params' => $data
        ]);
        $token = json_decode((string) $response->getBody(), true);

        return $token;
    }
}