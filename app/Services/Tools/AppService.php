<?php
/**
 * AppService.php
 * ==============================================
 * Copy right 2015-2021  by https://www.tianmtech.com/
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc : 应用服务
 * @author: zhanglinxiao<zhanglinxiao@tianmtech.cn>
 * @date: 2021/11/03
 * @version: v1.0.0
 * @since: 2021/11/03 09:11
 */

namespace App\Services\Tools;

use GuzzleHttp\Client;

class AppService
{

    private $host;
    private $appSecret;
    // 成功消息码
    public const SUCCESS_CODE = 200;

    public function __construct($host, $appSecret)
    {
        $this->host = $host;
        $this->appSecret = $appSecret;
    }

    /**
     * 获取请求头信息
     * @param $params
     * @param $secret_key
     * @return array
     */
    public function getHeader($params, $secret_key)
    {
        $timestamp = time();

        $params['timestamp'] = $timestamp;
        $sign = $this->generateSign($params, $secret_key);
        return array(
            'timestamp' => $timestamp,
            'sign' => $sign,
        );
    }

    /**
     * 生成签名
     *
     * @param $params
     * @param $secret
     * @return string
     * @author zhanglinxiao<zhanglinxiao@tianmtech.cn>
     * @since 2021/11/01 15:00
     */
    static public function generateSign($params, $secret = "")
    {
        $keys = array_keys($params);
        arsort($keys);
        $str = '';
        foreach ($keys as $key) {
            $val = $params[$key];
            if (is_array($val)) {
                $val = json_encode($val);
            }
            $str .= $key . $val;
        }

        if (!empty($secret)) {
            $str .= $secret;
        }

        $sig = md5($str);
        return $sig;
    }

    /**
     * 请求
     * @param $method
     * @param $url
     * @param $params
     * @param $header
     * @return array|bool
     */
    private function request($method, $url, $params, $header)
    {
        $result = false;

        $header["Content-Type"] = "application/json";
        try {
            $client = new Client();
            $req_result = $client->request($method, $url, array(
//                'body' => json_encode($params, JSON_UNESCAPED_UNICODE),
                'query' => $params,
                'headers' => $header
            ))->getBody()->getContents();
//            var_dump($url);
//            var_dump($req_result);
            if (!empty($req_result) && is_string($req_result)) {
                $req_result = json_decode($req_result, true);
                if (!empty($req_result) && is_array($req_result)) {
                    $result = $req_result;
                }
            }

        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
//            var_dump($e->getMessage());
            $result = false;
        }
        return $result;
    }

    /**
     * 发送注册短信验证码
     * @param $params
     * @param $host
     * @param $secret_key
     * @return array|mixed
     */
    public function sendRegisterSms($params)
    {
        $path = "/api/promotion/register/sms/code";
        $url = "{$this->host}{$path}";
        //获取头部信息，包含时间戳和签名
        $header = $this->getHeader($params, $this->appSecret);

        $req_result = $this->request('post', $url, $params, $header);
        $result = array();
        if (isset($req_result['code']) && $req_result['code'] == 200) {
            $smsCode = $req_result['data']['code'] ?? "";
            $result['sms_code'] = $smsCode;
        } else {
            if (!empty($req_result['message'])) {
                $result['error'] = $req_result['message'];
            } else if (!empty($req_result['msg'])) {
                $result['error'] = $req_result['msg'];
            }
        }
        return $result;
    }

    /**
     * 发送注册短信验证码
     * @param $params
     * @param $host
     * @param $secret_key
     * @return array|mixed
     */
    public function userRegister($params)
    {
        $path = "/api/promotion/user/register";
        $url = "{$this->host}{$path}";
        //获取头部信息，包含时间戳和签名
        $header = $this->getHeader($params, $this->appSecret);

        $req_result = $this->request('post', $url, $params, $header);


        $result = array();
        if (isset($req_result['code']) && $req_result['code'] == 200) {
            $result = $req_result['data'] ?? array();
        } else {
            if (!empty($req_result['message'])) {
                $result['error'] = $req_result['message'];
            } else if (!empty($req_result['msg'])) {
                $result['error'] = $req_result['msg'];
            }
        }
        return $result;
    }

    /**
     * 设置渠道颜色
     * @param $params
     *          channel_codes    渠道codes
     *          color           设置渠道颜色，如：#2E2F33。注：可为空字符串，空字符串则无颜色
     * @return array|mixed
     */
    public function setChannelColor($params)
    {
        $path = "/api/promotion/set/channel/color";
        $url = "{$this->host}{$path}";
        //获取头部信息，包含时间戳和签名
        $header = $this->getHeader($params, $this->appSecret);

        $req_result = $this->request('post', $url, $params, $header);
        $result = array();
        if (isset($req_result['code']) && $req_result['code'] == 200) {
            $result = $req_result['data'] ?? array();
        } else {
            if (!empty($req_result['message'])) {
                $result['error'] = $req_result['message'];
            } else if (!empty($req_result['msg'])) {
                $result['error'] = $req_result['msg'];
            } else {
                $result['error'] = "设置渠道颜色接口请求失败";
            }
            $req_result['error'] = $result['error'];
        }
        return $req_result;
        //return $result;
    }

    /**
     * 设置主播自动回复
     * @param $params
     *          channel_code        渠道code
     *          is_auto_reply       是否自动回复：是否自动回复：0-否；1-是；
     *          auto_reply_text     自动回复内容
     * @return array|mixed
     */
    public function setAnchorAutoReply($params)
    {
        $path = "/api/promotion/set/auto/reply";
        $url = "{$this->host}{$path}";
        //获取头部信息，包含时间戳和签名
        $header = $this->getHeader($params, $this->appSecret);

        $req_result = $this->request('post', $url, $params, $header);

        $result = array();
        if (isset($req_result['code']) && $req_result['code'] == 200) {
            $result = $req_result['data'] ?? array();
        } else {
            if (!empty($req_result['message'])) {
                $result['error'] = $req_result['message'];
            } else if (!empty($req_result['msg'])) {
                $result['error'] = $req_result['msg'];
            } else {
                $result['error'] = "设置主播自动回复接口请求失败";
            }
            $req_result['error'] = $result['error'];
        }
        return $req_result;
        //return $result;
    }


}
