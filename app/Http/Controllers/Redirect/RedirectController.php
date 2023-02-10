<?php
/**
 * UrlController.php
 * ==============================================
 * Copy right 2015-2021  by https://www.tianmtech.com/
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc : 应用数据
 * @author: zhanglinxiao<zhanglinxiao@tianmtech.cn>
 * @date: 2023/02/08
 * @version: v1.0.0
 * @since: 2023/02/08 09:11
 */

namespace App\Http\Controllers\Redirect;

use App\Enums\ContextEnum;
use App\Exceptions\BasicException;
use App\Http\Controllers\BaseController;
use App\Response\Response;
use Illuminate\Http\Request;

class RedirectController extends BaseController
{
    /**
     * @desc: 重定向跳转url
     * User: zhanglinxiao<zhanglinxiao@tianmtech.cn>
     * DateTime: 2023/02/08 15:19
     * ApiLink:get /{$shortKey}
     * @param Request $request
     * @return string
     * @throws BasicException
     */
    public function redirectUrl(Request $request, $shortKey)
    {
        $domain = $request->getHttpHost();
        $userAgent = $request->userAgent();
        $redirectInfo = app("logic_redirect")->getRedirectInfo($domain, $shortKey);

        //添加访问记录到redis缓存
        app("logic_redirect")->addRedirectVisitRecordToCache(array(
            'domain' => $domain,
            'short_key' => $shortKey,
            'user_agent' => $userAgent,
            'ip' => $request->ip(),
            'visit_time' => date("Y-m-d H:i:s"),
        ));


        //获取跳转页面封面html
//        $coverHtml = app("logic_redirect")->getCoverHtml($redirectInfo);
//        return (new \Symfony\Component\HttpFoundation\Response($coverHtml, 200,array(
//            'Content-Type'=>'text/html'
//        )));

        if (!empty($redirectInfo)) {
            //获取浏览器类型：0-其他；1-微信应用内置浏览器；2-QQ应用内置浏览器
            $browserType = app("logic_redirect")->getBrowserType($userAgent);
            if ($browserType == 0) {
                return redirect($redirectInfo['origin_url']);
            } else {
                //获取跳转页面封面html
                $coverHtml = app("logic_redirect")->getCoverHtml($redirectInfo);
                return (new \Symfony\Component\HttpFoundation\Response($coverHtml, 200,array(
                    'Content-Type'=>'text/html'
                )));
            }

        } else {
            return Response::sendData(array(), '地址不存在或链接已失效');
        }
    }

}