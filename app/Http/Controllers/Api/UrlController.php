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

namespace App\Http\Controllers\Api;

use App\Enums\ContextEnum;
use App\Exceptions\BasicException;
use App\Http\Controllers\BaseController;
use App\Response\Response;
use Illuminate\Http\Request;

class UrlController extends BaseController
{
    /**
     * @desc: 生成单个短链接
     * User: zhanglinxiao<zhanglinxiao@tianmtech.cn>
     * DateTime: 2023/02/08 15:19
     * ApiLink:post /api/url/shorten
     * @param Request $request
     * @return string
     * @throws BasicException
     */
    public function shortenUrl(Request $request)
    {

        $params = $this->validate($request, array(
            "url" => 'required|url',
            "domain" => 'string',
            "app_alias" => 'string',
        ));

        $appId = app("context")->get(ContextEnum::APP_ID, 0);

        //公共服务间调用用到
        if (empty($appId) && !empty($params['app_alias'])) {
            $appId = app("logic_cache_app")->getAppIdByAlias($params['app_alias']);
        }


        $result = app("logic_url")->shortenUrl($appId, $params);
        return Response::sendData($result);
    }

}