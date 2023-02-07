<?php
/**
 * RedisLockHelper.php
 * ==============================================
 * Copy right 2014-2020  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc : 基于redis实现的并发锁
 * @author: goen<goen88@163.com>
 * @date: 2020/5/28
 * @version: v2.0.0
 * @since: 2020/5/28 1:49 PM
 */


namespace Utils;


class RedisLockHelper
{

    /**
     * @var \Redis
     */
    private $redis;

    public function __construct(\Redis $redis)
    {
        $this->redis = $redis;
    }

    /**
     *
     * 互斥锁
     *
     * @param $strMutex 互斥key
     * @param $intTimeout 时长(s)
     * @param int $intMaxTimes 尝试次数
     * @date 2020/5/28 1:50 PM
     * @author goen<goen88@163.com>
     * @return bool
     */
    public  function mutexLock($strMutex, $intTimeout, $intMaxTimes = 0) {
        //加入请求互斥锁
        $objRedis = $this->redis;
        do{
            //使用incr原子型操作加锁
            $intRet   = $objRedis->incr($strMutex);
            if ($intRet === 1) {
                //设置过期时间，防止死任务的出现
                $objRedis->expire($strMutex, $intTimeout);
                return true;
            }
            if ($intMaxTimes > 0 && $intRet >= $intMaxTimes && $objRedis->ttl($strMutex) === -1) {
                //当设置了最大加锁次数时，如果尝试加锁次数大于最大加锁次数并且无过期时间则强制解锁
                $objRedis->del($strMutex);
                return false;
            }
            //降低抢锁频率　缓解redis压力
            usleep(1000*50);
        }while($intRet!==1);
    }

    /**
     *
     * 
     * @param $strMutex
     * @date 2020/5/28 1:59 PM
     * @author goen<goen88@163.com>
     */
    public  function cleanLock($strMutex){
        $this->redis->del($strMutex);
    }

}