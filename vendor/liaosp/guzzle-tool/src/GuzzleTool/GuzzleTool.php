<?php
/**
 * @author liaoshengping@haoxiaec.com
 * @Time: 2019/1/24 -16:18
 * @Version 1.0
 * @Describe:
 * 1:
 * 2:
 * ...
 */

namespace GuzzleTool;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class GuzzleTool
{
    protected $urlResources = [
        //授权
        'getAccessToken'      => '/oauth/token',
        //商品中心
        'getGoodsByProductId' => '/goods/get_goods_by_product_id',//根据productid获取商品信息
        'getAllGoods'         => '/goods/getAllOrderList',
        //用户中心
        'getUserInfoByOpenId' => '',//根据openid 获取用户信息
        'getAccessTokenInfo'=>'/oauth/check_token',
    ];
    protected $ServicesUrl;
    private $resources;
    private $url;
    private $param;
    private $headers = [];
    private $method = 'POST';
    protected $json;

    function __construct($resources = 'goods')
    {
        $this->resources = $resources;
    }

    public function param(array $data = [])
    {
        $this->param = $data;
        return $this;
    }


    public function getUrl($url = '')
    {
        $this->url = $url;
        $resources = $this->ServicesUrl;
        $resourcesres = $resources[$this->resources] ?? '';
        $myUrl = $this->urlResources;
        if (!empty($myUrl[$url])) {
            $url = $myUrl[$url];
        }
        return $resourcesres . $url;
    }

    public function method($method = 'POST')
    {
        $this->method = $method;
        return $this;
    }

    public function get($url = '')
    {
        $url = $this->getUrl($url);
        $net['url'] = $url;
        $net['params'] = $this->param;
        $net['headers'] = $this->headers;
        $net['method'] = $this->method;
        $net['json'] = $this->json;
        return self::sendRequest($net);
    }

    public function headers(array $headers = [])
    {
        $this->headers = $headers;
        return $this;
    }

    public function json($json = [])
    {
        $this->json = $json;
        return $this;
    }

    public function sendRequest(array $data)
    {
        try {
            $url = $data['url'];
            $client = new Client();
            $params = $data['params'] ?? [];
            $method = $data['request_method'] ?? 'POST';
            $timeout = $data['timeout'] ?? 10;
            $json = $data['json'] ?? [];
            $options = [
                'form_params' => $params,
                'timeout'     => $timeout,
            ];
            $token ='';
            if(!empty($_SERVER['HTTP_AUTHORIZATION'])){
                $token =$_SERVER['HTTP_AUTHORIZATION'];
            }
            if (!empty($data['headers'])) {
                $options['headers'] = $data['headers'];
            } else {
                $options['headers'] = [
                    'Authorization' => $token,
                    'Content-Type'  => 'application/json'
                ];
            }
            if (!empty($data['json'])) {
                $options['json'] = $json;
            }

            $response = $client->request($method, $url, $options);
            $result = $response->getBody();
            return json_decode($result, true);
        } catch (ClientException $e) {
            throw new \Exception($e->getMessage());
        }
    }
}