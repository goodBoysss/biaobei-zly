<?php
/**
 * ApiUtils.php
 * ==============================================
 * Copy right 2014-2019  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2019/6/14
 * @version: v2.0.0
 * @since: 2019/6/14 10:29 AM
 */


namespace Utils;


use LGCore\utils\LGUtils;
use URL\Normalizer;
use Etechnika\IdnaConvert\IdnaConvert;

class ApiUtils extends LGUtils
{

    /**
     *
     * 校验URL合法性，并返回合法的URL
     *
     * @param $url
     * @param string $defaultScheme
     * @date 2020/5/18 9:20 PM
     * @author goen<goen88@163.com>
     * @return bool|mixed
     */
    public  static function url_modify($url, $defaultScheme = 'http')
    {
        if (parse_url($url, PHP_URL_SCHEME) == null) {
            $url = $defaultScheme.'://'.trim($url, '/');
        }
        $url = (new Normalizer($url, true, true))->normalize();
        if (filter_var(IdnaConvert::encodeString($url), FILTER_VALIDATE_URL) === false) {
            return false;
        } else {
            $fragment = parse_url($url, PHP_URL_FRAGMENT);

            return str_replace('#'.$fragment, '#'.urldecode($fragment), $url);
        }
    }


    /**
     * 获取客户端真实IP
     *
     * @since 2020/5/19
     * @author goen88<goen88@163.com>
     * @return mixed
     */
    public static function real_remote_addr()
    {
        if (isset($_SERVER)){
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $realip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $realip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")){
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            }
        }
        return $realip;
    }

    /**
     *
     * 获取标准的URL
     *
     * @date 2020/5/19 10:08 AM
     * @author goen<goen88@163.com>
     */
    public static function getStandUrl($url,$slash="/"){
        $urls = parse_url($url);
        return $urls['scheme']."://".$urls['host'].$slash;
    }


    /**
     *
     * 短url转成数据库表名
     *
     * @date 2020/5/19 10:08 AM
     * @author goen<goen88@163.com>
     */
    public static function shortUrlToTabName($url,$pre="lyx_urls_"){
        $urls = parse_url($url);
        $urlStr  = str_replace(['-','.'],'_',$urls['host']);
        return $pre.$urlStr;
    }


    /**
     *
     * 获取短网址参数ID
     *
     * @param string $url
     * @date 2020/5/26 4:12 PM
     * @author goen<goen88@163.com>
     */
    public static function getShortUrlID(string $url){
        $urls = parse_url($url);
        return isset($urls['path'])? explode('/',$urls['path'])[1]  :'';
    }


}