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
    public function getRedirectUrl($domain, $shortKey)
    {
        $domainMd5 = md5($domain);

        $redirectUrlInfo = app("repo_redirect_url")->first(array(
            'domain_md5' => $domainMd5,
            'short_key' => $shortKey,
        ), array('origin_url'));

        if (!empty($redirectUrlInfo['origin_url'])) {
            $originUrl = $redirectUrlInfo['origin_url'];
        } else {
            $originUrl = "";
        }

        return $originUrl;
    }


}
