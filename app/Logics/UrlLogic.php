<?php
/**
 * UrlLogic.php
 * ==============================================
 * Copy right 2015-2021  by https://www.tianmtech.com/
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc : 链接
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

class UrlLogic
{

    /**
     * @desc: 生成单个短链接
     * @param $appId
     * @param $params
     * @return array
     * @throws BasicException
     * User: zhanglinxiao<zhanglinxiao@tianmtech.cn>
     * DateTime: 2023/02/08 20:40
     */
    public function shortenUrl($appId, $params)
    {
        if (empty($params['url'])) {
            throw new BasicException(10001, '链接不能为空');
        }

        $originUrl = $params['url'];

        //域名信息
        $domainInfo = $this->getDomainInfo($appId, $params);
        //域名
        $domain = $domainInfo['domain'];
        //域名md5
        $domainMd5 = $domainInfo['domain_md5'];

        //对生成短链的域名加锁
        $clockKey = sprintf(RedisKeyEnum::SHORTEN_URL, $domainMd5);
        $clockResult = app('redis')->set($clockKey, 1, 'ex', 30, 'nx');
        if (!$clockResult) {
            throw new BasicException(10008, '域名生成失败，请稍后再试');
        }

        //获取上一个短连接key（不存在则生成）
        $recentKeyInfo = $this->getRecentKeyInfo($domainMd5);

        //域名最近一个短链keyID
        $recentKeyId = $recentKeyInfo['recent_key_id'];
        //域名最近一个短链key
        $recentShortKey = $recentKeyInfo['recent_short_key'];

        //根据上一个短链key生成下一个短链key
        $shortKeyObj = new ShortKey();
        $shortKey = $shortKeyObj->next($recentShortKey);
        //短连接地址
        $shortUrl = "{$domain}/{$shortKey}";

        //更新域名最近一个短链key
        app("repo_domain_recent_key")->update($recentKeyId, array(
            'short_key' => $shortKey,
        ));

        //删除锁
        app('redis')->del($clockKey);

        //插入重定向跳转链接
        app("repo_redirect_url")->insert(array(
            'app_id' => $appId,
            'domain_md5' => $domainMd5,
            'short_key' => $shortKey,
            'origin_url' => $originUrl,
            'is_show_cover' => $params['is_show_cover'] ?? 0,
        ));

        //是否展示封面图（微信、QQ）：1-展示；0-不展示；
        if (isset($params['is_show_cover'])) {
            if ($params['is_show_cover'] == 1 && !empty($params['cover_image_url'])) {
                //插入跳转封面信息
                app("repo_redirect_cover")->insert(array(
                    'app_id' => $appId,
                    'domain_md5' => $domainMd5,
                    'short_key' => $shortKey,
                    'cover_image_url' => $params['cover_image_url'],
                ));
            }
        }

        return array(
            'domain' => $domain,
            'domain_md5' => $domainMd5,
            'origin_url' => $originUrl,
            'short_key' => $shortKey,
            'short_url' => $shortUrl,
        );

//        $urlInfo = parse_url($url);
//        if (empty($urlInfo['host'])) {
//            throw new BasicException(10001, '链接域名不能为空');
//        }
//        $domain = $urlInfo['host'];


    }

    /**
     * @desc: 获取短链域名
     * @param $appId
     * @param $params
     * @return array|int|mixed|string
     * @throws BasicException
     * User: zhanglinxiao<zhanglinxiao@tianmtech.cn>
     * DateTime: 2023/02/08 17:33
     */
    private function getDomainInfo($appId, $params)
    {
        //域名信息
        $domainInfo = array();
        //指定域名
        if (!empty($params['domain'])) {
            $domain = $params['domain'];
            $domainMd5 = md5($params['domain']);
            $domainInfo = app("repo_domain")->first(array(
                array('app_id', $appId),
                array('domain', $domain),
                array('domain_md5', $domainMd5),
            ), array('domain', 'domain_md5', 'is_published'));

        } else {//不指定域名
            $domainList = app("repo_domain")->get(array(
                array('app_id', $appId),
                array('is_published', 1),
            ), array('domain', 'domain_md5', 'is_published'), array(
                'id' => 'desc'
            ), '', 100)->toArray();
            if (!empty($domainList)) {
                $domainInfo = array_random($domainList);
            }
        }

        if (empty($domainInfo)) {
            throw new BasicException(10008, '不存在域名');
        }

        if ($domainInfo['is_published'] == 0) {
            throw new BasicException(10008, '域名已被关闭');
        }

        return $domainInfo;

    }


    /**
     * @desc: 获取域名最近的一个key
     * @return string
     * User: zhanglinxiao<zhanglinxiao@tianmtech.cn>
     * DateTime: 2023/02/08 18:48
     */
    private function getRecentKeyInfo($domainMd5)
    {
        $recentShortKey = "";

        $info = app("repo_domain_recent_key")->first(array(
            array('domain_md5', $domainMd5)
        ), array('id', 'short_key'), array(
            'id' => 'desc'
        ));

        if (!empty($info)) {
            $recentKeyId = $info['id'];
            $recentShortKey = $info['short_key'];
        }

        if (empty($recentShortKey)) {

            //随机生成
            $recentShortKey = md5(uniqid() . rand(1000, 9999));
            $recentShortKey = substr($recentShortKey, 0, 3);
        }

        if (empty($recentKeyId)) {
            $recentKeyId = app("repo_domain_recent_key")->insert(array(
                'domain_md5' => $domainMd5,
                'short_key' => $recentShortKey,
            ));
        }

        return array(
            'recent_key_id' => $recentKeyId,
            'recent_short_key' => $recentShortKey,
        );
    }


}
