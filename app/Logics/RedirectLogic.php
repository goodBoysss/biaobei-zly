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
     * @return mixed|string
     * User: zhanglinxiao<zhanglinxiao@tianmtech.cn>
     * DateTime: 2023/02/08 21:20
     */
    public function getRedirectInfo($domain, $shortKey)
    {
        $domainMd5 = md5($domain);

        //先从缓存获取
        $clockKey = sprintf(RedisKeyEnum::REDIRECT_URLS, $domainMd5, $shortKey);
        $redirectInfo = app("redis")->get($clockKey);
        if (!empty($redirectInfo)) {
            //存在缓存中
            $redirectInfo = json_decode($redirectInfo, true);
        } else {
            $redirectUrlInfo = app("repo_redirect_url")->first(array(
                'domain_md5' => $domainMd5,
                'short_key' => $shortKey,
            ), array('origin_url', 'is_show_cover'), array(
                'id' => 'desc'
            ));

            //todo::
            $redirectInfo = array(
                'origin_url' => $redirectUrlInfo['origin_url'],
                'is_show_cover' => $redirectUrlInfo['is_show_cover'],
                'cover_url' => "https://pics7.baidu.com/feed/18d8bc3eb13533fa43998137bd0d4f1440345be1.jpeg@f_auto?token=05942c87493edc76c28e299ce4dbe69e",
            );

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
        } else if (strpos($userAgent, 'MQQBrowser') !== false) {
            $browserType = 2;
        }

        return $browserType;
    }

    /**
     * @desc: 方法描述
     * @param $userAgent
     * @return string
     * User: zhanglinxiao<zhanglinxiao@tianmtech.cn>
     * DateTime: 2023/02/10 16:25
     */
    public function getCoverHtml($redirectInfo)
    {
        $redirectInfo['cover_url'] = "https://img04.sogoucdn.com/v2/thumb/retype_exclude_gif/ext/auto/q/80/crop/xy/ai/t/0/w/562/h/752?appid=122&url=https://img01.sogoucdn.com/app/a/100520020/774210cf558ba3ccfba38873ea713d33";
        $coverHtml = "<html><body><img src='{$redirectInfo['cover_url']}' href='{$redirectInfo['origin_url']}' width='100%' /></body><html>";
        return $coverHtml;
    }


}
