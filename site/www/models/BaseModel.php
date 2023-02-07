<?php

namespace Models;

use LGCore\utils\LGHttp;
use LGCore\utils\LGMCrypt;

class BaseModel {

    private $app_key = 'backend';

    public function __construct() {
    }

    /**
     * API请求函数
     * @param string $url [地址]
     * @param array $params [参数数组]
     * @param string $method [请求类型：get/post]
     * @param string $v [api版本号]
     * @param string $pem [证书地址]
     * @return array
     * @since File available since Version 1.0 2016-5-25
     * @author goen<goen88@163.com>
     * @copyright 2016 by gaorunqiao.ltd
     */
    public function apiRequest($url, $params = [], $method = 'get', $v = '1.0', $pem = null) {
        $url = LG_API_URL . $url; //请求地址
        $_params = [
            'v' => $v,
            'sig' => uniqid(),
            'app_key' => $this->app_key,
            'app_version' => APP_VERSION,
            '_skip_ak_auth' => 1
        ];

        if (!empty($_params)) {
            $_params = array_merge($_params, $params);
        }

        //如果开启HTTP全局参数值加密
        if (defined('LG_AES_HTTP_PARAMERS_ENCODE') && LG_AES_HTTP_PARAMERS_ENCODE == true) {
            $aesObj = new LGMCrypt();
            foreach ($_params as $k => $v) {
                if (!is_array($v)) { //如果不是数组格式则进行AES加密
                    $_params[$k] = $aesObj->encryptV2($v);
                }
            }
        }

        $rlt = null;
        //判断请求类型
        if ($method == "get") {
            $rlt = LGHttp::GET($url, $pem, $_params);
        } else if ($method == "post") {
            $rlt = LGHttp::POST($url, $pem, $_params);
        }

        if ($rlt) {
            if ($rlt['meta']['status'] == '0') {
                return $rlt['data'];
            } else {
                return ['error' => $rlt['data']['alert_msg'], 'error_code' => $rlt['meta']['status']];
            }
        } else {
            return ['error' => 'api接口请求失败', 'error_code' => 40002];
        }
    }

    /**
     * 文件上传API请求
     * @param string $url [地址]
     * @param string $files_name [$_FILES文件的inpt元素的name ]
     * @param array $params [参数数组]
     * @param string $v [api版本号]
     * @param string $pem [证书地址]
     * @return array
     * @since File available since Version 1.0 2016-5-26
     * @author goen<goen88@163.com>
     * @copyright 2016 by gaorunqiao.ltd
     */
    public function uploadRequest($url, $files_name, $params = [], $v = '1.0', $pem = null) {
        $url = LG_UPLOAD_URL . $url;
        $_params = [
            'v' => $v
            , 'sig' => uniqid()
            , 'app_key' => $this->app_key
            , "access_key" => UPLOAD_ACCESS_KEY
            , "access_scrept" => UPLOAD_ACCESS_SCRIPT
        ];

        if (!empty($_params)) {
            $_params = array_merge($_params, $params);
        }
        $rlt = LGHttp::UPLOAD_FILES($url, $files_name, $_params);
        if ($rlt) {
            if ($rlt['meta']['status'] == '0') {
                return $rlt['data']['items'];
            } else {
                return ['error' => $rlt['data']['alert_msg'], 'error_code' => $rlt['meta']['status']];
            }
        } else {
            return ['error' => '上传api接口请求失败', 'error_code' => 40002];
        }
    }

}