<?php
/**
 * RedirectVisitRecordCommand.php
 * ==============================================
 * Copy right 2015-2022  by https://www.tianmtech.com/
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc: 同步跳转访问记录（从redis同步到数据库）
 * @author: zhanglinxiao<zhanglinxiao@tianmtech.cn>
 * @date: 2023/02/15
 * @version: v1.0.0
 * @since: 2023/02/15 13:23
 */

namespace App\Console\Commands\Sync;

use App\Enums\RedisKeyEnum;
use Illuminate\Console\Command;

class SyncVisitRecordCommand extends Command
{
    //命令名
    protected $signature = 'sync:visit:record';

    //命令描述
    protected $description = '同步跳转访问记录（从redis同步到数据库）';

    //业务处理
    public function handle()
    {

        $this->info("开始执行:【" . date("Y-m-d H:i:s") . "】");

        try {
            $total = 0;
            $limit = 2000;
            do {
                //通过redis获取访问记录数据
                $data = $this->getVisitRecord($limit);
                if (!empty($data)) {
                    app("logic_redirect")->syncVisitRecord($data);
                }
                $total += count($data);
            } while (count($data) == $limit && $total < 100000);
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }

        $this->info("执行结束:【" . date("Y-m-d H:i:s") . "】");
    }

    /**
     * @desc: 通过redis获取访问记录数据
     * @param $limit
     * @return array
     * User: zhanglinxiao<zhanglinxiao@tianmtech.cn>
     * DateTime: 2023/02/14 18:29
     */
    private function getVisitRecord($limit)
    {
        $records = array();
        $redisKey = sprintf(RedisKeyEnum::REDIRECT_VISIT_RECORD);
        do {
            $data = app("redis")->rpop($redisKey);
            $data = json_decode($data, true);
            if (!empty($data['app_id']) && !empty($data['domain']) && !empty($data['short_key']) && !empty($data['visit_time'])) {
                $records[] = $data;
            }
        } while (!empty($data) && count($records) < $limit);
        return $records;
    }

}
