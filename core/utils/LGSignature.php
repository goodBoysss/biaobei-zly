<?php
/**
 * LGSignature.php
 * ==============================================
 * Copy right 2014-2019  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc : API数字签名算法，基于hmac的sha1
 * @author: goen<goen88@163.com>
 * @date: 2019/1/3
 * @version: v2.0.0
 * @since: 2019/1/3 10:45
 */

namespace LGCore\utils;

class LGSignature
{
    /**
     *
     * 生成数字签名，基于hmac的sha1算法
     *
     * @param $signId 签名/应用ID
     * @param $signSecret 签名/应用秘钥
     * @param $timestamp 时间戳
     * @param $nonce 随机数
     * @author goen<goen88@163.com>
     * @return string
     */
    public static function generateSignature($signId,$signSecret,$timestamp,$nonce){
        $paramsArr = array(
            'app_signature_id'=> trim($signId),
            'timestamp'=>$timestamp,
            'nonce'=>$nonce
        );

        //参数进行排序
        ksort($paramsArr);

        //sign string
        $paramsStr = http_build_query($paramsArr);

        $signStr = base64_encode(hash_hmac('sha1', $paramsStr, $signSecret, false));
        return $signStr;
    }


    /**
     *
     * 校验签名的有效性
     *
     * @param $signature 原始签名
     * @param $signId 签名/应用ID
     * @param $signSecret 签名/应用秘钥
     * @param $timestamp 时间戳
     * @param $nonce 随机数
     * @author goen<goen88@163.com>
     */
    public static function checkSignature($signature,$signId,$signSecret,$timestamp,$nonce){
        $lefttime = $timestamp-time();
        if($lefttime<=0){
            return array(
                'error_code'=>500,
                'error_message'=>'签名已失效。',
            );
        }

        $newSignature = self::generateSignature($signId,$signSecret,$timestamp,$nonce);

        if($signature!=$newSignature){
            return array(
                'error_code'=>500,
                'error_message'=>'签名校验错误。',
            );
        }

        return true;
    }


}