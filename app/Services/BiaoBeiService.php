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

namespace App\Services;

use GuzzleHttp\Client;

class BiaoBeiService
{

    public function getAccessToken($client_id, $client_secret)
    {
        //获取访问令牌
//        $client_secret = 'd65d2415474545d6b0813898ac2cb851'; //应用secret
//        $client_id = 'd8fbe6a8deef4f78bc028e72305e5648'; //应用id
        $grant_type = 'client_credentials'; //固定格式

        //1.获取token
        $url = 'https://openapi.data-baker.com/oauth/2.0/token?grant_type=' . $grant_type . '&client_id=' . $client_id . '&client_secret=' . $client_secret;

        //curl get请求
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //信任任何证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // 检查证书中是否设置域名,0不验证
        $token_res = curl_exec($ch);

        //如果错误 查看错误信息
        if (curl_errno($ch)) {
            print curl_error($ch);
        }
        curl_close($ch);

        //进行token信息解析
        $token_info = json_decode($token_res, 1);
        $access_token = $token_info['access_token'];    //获取到的token信息

        return $access_token;
    }

    public function generateSound($voiceName, $text)
    {
        $client_id = "b647e4bffb5b4b4392628194138141ff";
        $client_secret = "5fd0329f5e634db6ac2e3967f67b567e";

        $accessToken = $this->getAccessToken($client_id, $client_secret);


        $params = array(
            'access_token' => $accessToken,
            'domain' => 1,
            'language' => 'zh',
            'voice_name' => $voiceName,
            'text' => $text,
        );

        $url = "https://openapi.data-baker.com/tts_personal?" . http_build_query($params);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;

    }

}
