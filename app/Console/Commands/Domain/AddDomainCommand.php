<?php
/**
 * CreateDomainCommand.php
 * ==============================================
 * Copy right 2015-2022  by https://www.tianmtech.com/
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc: 新增域名
 * @author: zhanglinxiao<zhanglinxiao@tianmtech.cn>
 * @date: 2023/02/15
 * @version: v1.0.0
 * @since: 2023/02/15 13:23
 */

namespace App\Console\Commands\Domain;

use App\Exceptions\BasicException;
use Illuminate\Console\Command;

class AddDomainCommand extends Command
{
    //命令名
    protected $signature = 'domain:add {--app_id=} {--domain=}';

    //命令描述
    protected $description = '新增域名';

    //业务处理
    public function handle()
    {

        $this->info("开始执行:【" . date("Y-m-d H:i:s") . "】");

        //开始ID
        $appId = $this->option('app_id');
        $domain = $this->option('domain');
        if (!empty($domain)) {
            $appId = !empty($appId) ? $appId : 0;
            $this->addDomain($appId, $domain);
        } else {
            $this->error("域名不能为空");
        }

        $this->info("执行结束:【" . date("Y-m-d H:i:s") . "】");
    }

    /**
     * @desc: 新增域名
     * User: zhanglinxiao<zhanglinxiao@tianmtech.cn>
     * DateTime: 2023/02/21 17:58
     */
    private function addDomain($appId, $domain)
    {
        $appInfo = app("repo_app")->first(array(
            array('id', $appId)
        ), array('id', 'name'));

//        if (empty($appInfo)) {
//            throw new BasicException(10008, '应用不存在');
//        }

        $urlInfo = parse_url($domain);
        if (count($urlInfo) == 1 && !empty($urlInfo['path']) && $urlInfo['path'] == $domain) {
            //例如：www.tianmiao.com
        } elseif (count($urlInfo) == 2 && !empty($urlInfo['scheme']) && !empty($urlInfo['host'])) {
            //例如：http(s)://www.tianmiao.com，去除http(s)
            $domain = $urlInfo['host'];
        }  elseif (count($urlInfo) == 3 && !empty($urlInfo['scheme']) && !empty($urlInfo['host']) && !empty($urlInfo['path'])) {
            //例如：http(s)://www.tianmiao.com/，去除http(s)和后面斜杠
            $domain = $urlInfo['host'];
        } else {
            throw new BasicException(10008, '域名不合法');
        }

        $domainMd5 = md5($domain);

        $domainInfo = app("repo_domain")->first(array(
            array('domain_md5', $domainMd5)
        ), array('domain_md5'));

        if (!empty($domainInfo)) {
            throw new BasicException(10008, '域名已被本应用或其他应用使用');
        }

        app("repo_domain")->insert(array(
            'app_id' => $appId,
            'domain' => $domain,
            'domain_md5' => $domainMd5,
            'is_published' => 1,
        ));

        $this->info("应用：[{$appId}]，域名：[{$domain}]创建成功");
    }

}
