<?php
/**
 * RedirectLogic.php
 * ==============================================
 * Copy right 2015-2021  by https://www.tianmtech.com/
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc : 重定向url
 * @author: zhanglinxiao<zhanglinxiao@tianmtech.cn>
 * @date: 2023/01/11
 * @version: v1.0.0
 * @since: 2023/01/11 09:11
 */

namespace App\Logics;

use App\Common\ShortKey;
use App\Enums\RedisKeyEnum;
use App\Exceptions\BasicException;
use Illuminate\Support\Facades\DB;

class RedirectLogic
{

    /**
     * @desc: 获取重定向url
     * @param $domain
     * @param $shortKey
     * @param bool $isUseCache 是否使用缓存：true-优先读缓存数据；false-不读缓存数据
     * @return mixed|string
     * User: zhanglinxiao<zhanglinxiao@tianmtech.cn>
     * DateTime: 2023/02/08 21:20
     */
    public function getRedirectInfo($domain, $shortKey, bool $isUseCache = true)
    {
        $domainMd5 = md5($domain);

        //先从缓存获取
        $redisKey = sprintf(RedisKeyEnum::REDIRECT_URLS, $domainMd5, $shortKey);
        $redirectInfo = app("redis")->get($redisKey);
        if (!empty($redirectInfo) && $isUseCache === true) {
            //存在缓存中
            $redirectInfo = json_decode($redirectInfo, true);
        } else {
            $redirectUrlInfo = app("repo_redirect_url")->first(array(
                array('domain_md5', $domainMd5),
                array(DB::raw("BINARY short_key"), $shortKey),
            ), array('app_id', 'origin_url', 'is_show_cover'), array(
                'id' => 'desc'
            ));
            if (empty($redirectUrlInfo)) {
                throw new BasicException(10008, '链接已失效');
            }

            $redirectInfo = array(
                'app_id' => $redirectUrlInfo['app_id'],
                'origin_url' => $redirectUrlInfo['origin_url'],
                'is_show_cover' => $redirectUrlInfo['is_show_cover'],
                'cover_image_url' => "",
            );

            //展示跳转封面
            if ($redirectInfo['is_show_cover'] == 1) {
                $redirectCoverInfo = app("repo_redirect_cover")->first(array(
                    array('domain_md5', $domainMd5),
                    array(DB::raw("BINARY short_key"), $shortKey),
                ), array('cover_image_url'));
                if (!empty($redirectCoverInfo['cover_image_url'])) {
                    $redirectInfo['cover_image_url'] = $redirectCoverInfo['cover_image_url'];
                }
            }
        }

        return $redirectInfo;
    }

    /**
     * @desc: 添加访问记录到redis缓存
     * @param $params
     * User: zhanglinxiao<zhanglinxiao@tianmtech.cn>
     * DateTime: 2023/02/09 16:36
     */
    public function addRedirectVisitRecordToCache($params)
    {
        app("redis")->lpush(RedisKeyEnum::REDIRECT_VISIT_RECORD, json_encode($params));
    }


    /**
     * @desc: 获取浏览器类型：0-其他；1-微信应用内置；2-QQ应用内置
     * @return int
     * User: zhanglinxiao<zhanglinxiao@tianmtech.cn>
     * DateTime: 2023/02/10 15:54
     */
    public function getBrowserType($userAgent): int
    {
        $browserType = 0;

        if (strpos($userAgent, 'MicroMessenger') !== false) {
            $browserType = 1;
//        } else if (strpos($userAgent, 'MQQBrowser') !== false) {
        } else if (preg_match('/QQ\/[0-9]/i', $userAgent)) {
            $browserType = 2;
        }

        return $browserType;
    }

//    /**
//     * @desc: 方法描述
//     * @param $userAgent
//     * @return string
//     * User: zhanglinxiao<zhanglinxiao@tianmtech.cn>
//     * DateTime: 2023/02/10 16:25
//     */
//    public function getCoverHtml($redirectInfo)
//    {
//        $redirectInfo['cover_url'] = "https://img04.sogoucdn.com/v2/thumb/retype_exclude_gif/ext/auto/q/80/crop/xy/ai/t/0/w/562/h/752?appid=122&url=https://img01.sogoucdn.com/app/a/100520020/774210cf558ba3ccfba38873ea713d33";
//        $coverHtml = "
//            <html>
//                <body style='margin: 0;position: relative;'>
//                    <img style='position: fixed ; top: 0;' src='https://channel-prod.obs.cn-east-3.myhuaweicloud.com:443/open_by_browser.JPG?AccessKeyId=U6QEPWLSFURLXGYZKW9L&Expires=1707127797&Signature=s0Sbyykh6gA8GQ6ftx%2BfM0Bk2sE%3D' href='{$redirectInfo['origin_url']}' width='100%' />
//                    <img style='margin-top:17.5vw' src='{$redirectInfo['cover_url']}' href='{$redirectInfo['origin_url']}' width='100%' />
//                </body>
//            <html>";
//        return $coverHtml;
//    }

    /**
     * @desc: 同步跳转访问记录
     * @param $data
     * User: zhanglinxiao<zhanglinxiao@tianmtech.cn>
     * DateTime: 2023/02/14 19:25
     */
    public function syncVisitRecord($data)
    {
        //将访问次数多的链接写入redis
        $this->saveRedirectInfoToCache($data);
        //保存访问记录
        $this->saveVisitRecord($data);
    }


    /**
     * @desc: 将访问次数多的链接写入redis
     * @param $data
     * @throws BasicException
     * User: zhanglinxiao<zhanglinxiao@tianmtech.cn>
     * DateTime: 2023/02/15 13:36
     */
    public function saveRedirectInfoToCache($data)
    {
        //访问次数，大于等于这个次数就加入缓存
        $maxNum = 3;
        //缓存过期时间，单位秒
        $expireSeconds = 3 * 60;
        $list = array();
        foreach ($data as $v) {
            if (!empty($v['app_id']) && !empty($v['domain']) && !empty($v['short_key']) && !empty($v['visit_time'])) {
                $domain = $v['domain'];
                $domainMd5 = md5($domain);
                $shortKey = $v['short_key'];
                $visitTime = $v['visit_time'];
                //一小时内点击的
                if (strtotime($visitTime) > time() - 60 * 60) {
                    $uuid = md5("{$domainMd5}_{$shortKey}");
                    if (isset($list[$uuid])) {
                        $list[$uuid]['visit_num']++;
                    } else {
                        $list[$uuid] = array(
                            'domain' => $domain,
                            'domain_md5' => $domainMd5,
                            'short_key' => $shortKey,
                            'visit_num' => 1,
                        );
                    }
                }
            }
        }

        foreach ($list as $v) {

            if ($v['visit_num'] >= $maxNum) {
                $domain = $v['domain'];
                $domainMd5 = $v['domain_md5'];
                $shortKey = $v['short_key'];

                $redisKey = sprintf(RedisKeyEnum::REDIRECT_URLS, $domainMd5, $shortKey);
                $redirectInfo = app("redis")->get($redisKey);
                if (empty($redirectInfo)) {
                    $redirectInfo = $this->getRedirectInfo($domain, $shortKey, false);
                    app("redis")->setex($redisKey, $expireSeconds, json_encode($redirectInfo));
                } else {
                    app("redis")->expire($redisKey, $expireSeconds);
                }
            }
        }
    }

    /**
     * @desc: 保存访问记录
     * @param $data
     * User: zhanglinxiao<zhanglinxiao@tianmtech.cn>
     * DateTime: 2023/02/15 12:00
     */
    public function saveVisitRecord($data)
    {
        $insertData = array();
        foreach ($data as $v) {
            if (!empty($v['app_id']) && !empty($v['domain']) && !empty($v['short_key']) && !empty($v['visit_time'])) {
                $insertData[] = array(
                    'app_id' => $v['app_id'],
                    'domain_md5' => md5($v['domain']),
                    'short_key' => $v['short_key'],
                    'visit_time' => $v['visit_time'],
                    'user_agent' => $v['user_agent'] ?? '',
                    'ip' => $v['ip'] ?? '',
                );
            }
        }

        if (!empty($insertData)) {
            app('repo_redirect_visit_record')->insertRows($insertData);
        }
    }

}
