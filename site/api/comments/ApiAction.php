<?php
/**
 * ApiAction.php
 * ==============================================
 * Copy right 2014-2019  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2019/6/14
 * @version: v2.0.0
 * @since: 2019/6/14 12:41 PM
 */

namespace Comments;

use LGCore\base\LG;
use LGCore\base\LGAction;
use LGCore\log\LGError;
use Models\ApiAuthorizeModel;
use Models\BlackipListModel;
use Utils\ApiUtils;

class ApiAction extends LGAction {

    /**
     * secure key
     * @var string
     */
    protected $seckey = 'd1f68c9b37b7897405687ea464ce195c';
    /**
     * Application deive name ,for exapple iPhone
     * 调用接口时候代表客户端的唯一身份，iPhone客户端为"iPhone"；Android为"Android"；iPad为"iPad"
     * @var string
     */
    protected $app_key = '';
    /**
     * API接口的版本号
     * @var float
     */
    protected $v = '';//1.0;
    /**
     * 签名
     * @var string
     */
    protected $sig = '';
    /**
     * 页码
     * @var int
     */
    protected $page = 1;
    /**
     * 每页显示数量
     * @var int
     */
    protected $count = 10;


    /**
     * 批量生成URL数量
     * @var int
     */
    protected $batchUrlsNum = 100;

    /**
     *
     * 支持的app_key值,iPhone客户端为"iPhone"；Android为"Android"；iPad为"iPad"
     * @var array
     */
    private $_suport_app_key = array('iphone', 'android', 'ipad', 'backend', 'oms', 'sale_iphone', 'sale_android', 'wap', 'wisdom', 'wxapp', 'qywx', 'www_web');

    public function __construct($is_init = true) {
        header ( "content-type:application/json; charset=utf-8" );
        header("Access-Control-Allow-Origin:*"); // 允许跨域访问

        parent::__construct();
        if ($is_init == true) {
            $this->init();
        }
    }

    protected function init() {
        $this->check_app_key();
//        $this->check_version();
//        $this->check_sign();

        $this->checkAKSK();
        $this->checkBlackIp();
        $this->check_count();
        $this->check_page();
    }

    /**
     * 检查app_key是否存在
     * @return null
     * @author goen<goen88@163.com>
     * @since File available since Version 1.0 2016-1-4
     */
    protected function check_app_key() {
        if (LG::reqeust()->hasKey('app_key')) {
            $this->app_key = LG::reqeust()->getString('app_key');
        }
        if (empty($this->app_key)) {
            LG::rest(10009, array('alert_msg' => '参数[app_key]不能为空'));
        }
        if (in_array(strtolower($this->app_key), $this->_suport_app_key) == false) {
            LG::rest(10010, array('alert_msg' => '参数[app_key]值不合法'));
        }
    }

    /**
     * 检查v是否存在
     * @return null
     * @author goen<goen88@163.com>
     * @since File available since Version 1.0 2016-1-4
     */
    protected function check_version() {
        if (LG::reqeust()->hasKey('v')) {
            $this->v = LG::reqeust()->getString('v');
        }
        if (empty($this->v)) {
            LG::rest(10009, array('alert_msg' => '参数[v]不能为空'));
        }
    }

    /**
     * 检查sig是否存在
     * @return null
     * @author goen<goen88@163.com>
     * @since File available since Version 1.0 2016-1-4
     */
    protected function check_sign() {
        if (LG::reqeust()->hasKey('sig')) {
            $this->sig = LG::reqeust()->getString('sig');
        }
        if (empty($this->sig)) {
            LG::rest(10009, array('alert_msg' => '参数[sig]不能为空'));
        }
        //校验签名有效性
        //LGSignature::checkSignature($this->sig,);
    }

    /**
     * 检查page是否存在
     * @return null
     * @author goen<goen88@163.com>
     * @since File available since Version 1.0 2016-1-4
     */
    protected function check_page() {

        if (LG::reqeust()->hasKey('page') && LG::reqeust()->hasKey('count')) {
            $_page = LG::reqeust()->getInt('page') < 1 ? 1 : LG::reqeust()->getInt('page');
            $_count = LG::reqeust()->getInt('count') < 0 ? $this->count : LG::reqeust()->getInt('count');
            $this->page = ($_page - 1) * $_count;
        } else if (LG::reqeust()->hasKey('page')) {
            $_page = LG::reqeust()->getInt('page') < 1 ? 1 : LG::reqeust()->getInt('page');
            $this->page = ($_page - 1) * $this->count;
        } else {
            $this->page = ($this->page - 1) * $this->count;
        }
    }

    /**
     * 检查count是否存在
     * @return null
     * @author goen<goen88@163.com>
     * @since File available since Version 1.0 2016-1-4
     */
    protected function check_count() {
        if (LG::reqeust()->hasKey('count')) {
            $this->count = LG::reqeust()->getInt('count');
        }
    }


    /**
     *
     * 检查黑名单
     *
     * @date 2020/6/16 4:39 下午
     * @author goen<goen88@163.com>
     */
    public function checkBlackIp(){
        $_skip_ak_auth = $this->apiParamCheck('_skip_ak_auth','string',"Skip Auth",false);
        if($this->app_key=='backend'&&$_skip_ak_auth==1){
            return true;
        }
        $curIP = ApiUtils::real_remote_addr();
        $blackipModel = new BlackipListModel();
        $rlt = $blackipModel->getOneByIp($curIP);
        if(!empty($rlt)){
            LG::rest(27003, array('alert_msg' => '您已被限制访问'));
        }
    }

    /**
     *
     * 校验Aaccess Key/Secret Key
     *
     * @date 2020/6/16 12:29 下午
     * @author goen<goen88@163.com>
     */
    public function checkAKSK(){
        $_skip_ak_auth = $this->apiParamCheck('_skip_ak_auth','string',"Skip Auth",false);
        if($this->app_key=='backend'&&$_skip_ak_auth==1){
            return true;
        }

        $ak = $this->apiParamCheck('_ak','string',"Access Key",true);
        $token = $this->apiParamCheck('_token','string',"Access Token",true);
        $rdsAKKey = "lyx_urls_ak_".$ak;

        $rdsAKRlt = LG::$redis->get($rdsAKKey);
        if(!$rdsAKRlt){
            //通过access key 获取Secret Key
            $apiAuthorizeModel = new ApiAuthorizeModel();
            $rlt = $apiAuthorizeModel->getOneByAccessKey($ak,'*');
        }else{
            $rlt = \json_decode($rdsAKRlt,true);
        }

        if(is_array($rlt)&&array_key_exists('secret_key',$rlt)){
            //获取每批生成URL的数量
            $this->batchUrlsNum = isset($rlt['batch_num'])?intval($rlt['batch_num']):100;

            //当前请求的IP
            $curIP = ApiUtils::real_remote_addr();
            //请求频率控制
            $this->dealRequestRate($curIP,$rlt);

            //检测API的状态
            if( isset($rlt['status']) && $rlt['status']!=1 ){
                LG::rest(26003, array('alert_msg' => 'API授权接口不可用。'));
            }
            //检测ak是否过期
            if( isset($rlt['expire'])
                &&!empty($rlt['expire'])
                &&$rlt['expire']!='0000-00-00 00:00:00'
                && strtotime($rlt['expire'])<time()
            ){
                LG::rest(26003, array('alert_msg' => 'Token已过期，请联系运营商'));
            }
            //如果是白名单模式,检查白名
            if( isset($rlt['access_type']) && $rlt['access_type']==2 ){
                $whiteList = explode(',',str_replace('，',',',$rlt['white_list']));
                $allow = false;
                foreach ($whiteList as $v){
                    if(strpos($curIP,$v)!==false){
                        $allow = true;
                        break;
                    }
                }
                if($allow==false){
                    LG::rest(27002, array('alert_msg' => '没有权限访问,不在白名单范围内'));
                }
            }

            //token有效性比对
            if($token==md5($rlt['access_key'].".".$rlt['secret_key'])){
                if(!$rdsAKRlt){
                    LG::$redis->set($rdsAKKey,\json_encode($rlt),1800);
                }
                return true;
            }else{
                LG::rest(26003, array('alert_msg' => 'Token验证失败'));
            }
        }else{
            LG::rest(26003, array('alert_msg' => '无效的AccessKey'));
        }
    }

    /**
     * 检查是否POST请求
     *
     * @since File available since Version 1.0 2016-1-4
     * @author goen<goen88@163.com>
     * @return null
     */
    public function check_post_method(){
        if(!LG::reqeust()->isPost()){
            LG::rest(91001, array('alert_msg'=>'请使用POST请求'));
        }
    }


    /**
     * 校验API http参数
     *
     * @param string $key [参数键值]
     * @param string $type [参数类型:int、float、string、bool、double、array]
     * @param string $note [参数含义]
     * @param bool $required [是否必须，默认必须]
     * @return mixed
     * @since File available since Version 1.0 2016-5-5
     * @author goen<goen88@163.com>
     * @copyright 2016 by gaorunqiao.ltd
     */
    public function apiParamCheck($key, $type, $note, $required = true, $default = null) {
        $rlt = $this->paramCheck($key, $type, $note, $required);
        if (is_array($rlt) && array_key_exists('error', $rlt)) {
            LG::rest($rlt['error_code'], array('alert_msg' => $rlt['error']));
        }
        return $rlt;
    }


    /**
     * 处理请求频率
     *
     * @param string $ip
     * @date 2020/6/16 5:19 下午
     * @author goen<goen88@163.com>
     */
    protected function dealRequestRate(string $ip,array $apiAuth){

        if(is_array($apiAuth)){
            $longIp = ip2long($ip); //转换IP为long
            $rateMinute =  isset($apiAuth['rate_minute'])?(int)$apiAuth['rate_minute']:0;
            $rateHour = isset($apiAuth['rate_hour'])?(int)$apiAuth['rate_hour']:0;
            $rateDay =  isset($apiAuth['rate_day'])?(int)$apiAuth['rate_day']:0;
            $rateMonth =  isset($apiAuth['rate_month'])?(int)$apiAuth['rate_month']:0;
            //只有当大于0时才开启限制，0表示不限制
            if($rateMinute>0){
                $rdsRateMinuteKey = 'lyx_urls_ak_ip_minute_'.$longIp;
                $minInc = LG::$redis->incr($rdsRateMinuteKey);
                if($minInc===1){ //设置失效时间
                    LG::$redis->expire($rdsRateMinuteKey, 60); //单位(s)
                }
                if($minInc>$rateMinute){
                    LG::rest(27004, array('alert_msg' => "1分钟访问超出限制，请稍后访问"));
                }
            }
            if($rateHour>0){
                $rdsRateHourKey = 'lyx_urls_ak_ip_hour_'.$longIp;
                $hourInc = LG::$redis->incr($rdsRateHourKey);
                if($hourInc===1){ //设置失效时间
                    LG::$redis->expire($rdsRateHourKey, 3600); //单位(s)
                }
                if($hourInc>$rateHour){
                    LG::rest(27004, array('alert_msg' => "1小时访问超出限制，请稍后访问"));
                }
            }
            if($rateDay>0){
                $rdsRateDayKey = 'lyx_urls_ak_ip_day_'.$longIp;
                $dayInc = LG::$redis->incr($rdsRateDayKey);
                if($dayInc===1){ //设置失效时间
                    LG::$redis->expire($rdsRateDayKey, 3600*24); //单位(s)
                }
                if($dayInc>$rateDay){
                    LG::rest(27004, array('alert_msg' => "1天访问超出限制，请稍后访问"));
                }
            }
            if($rateMonth>0){
                $rdsRateMonthKey = 'lyx_urls_ak_ip_month_'.$longIp;
                $monthInc = LG::$redis->incr($rdsRateMonthKey);
                if($monthInc===1){ //设置失效时间
                    LG::$redis->expire($rdsRateMonthKey, 3600*24*30); //单位(s)
                }
                if($monthInc>$rateMonth){
                    LG::rest(27004, array('alert_msg' => "1月访问超出限制，请稍后访问"));
                }
            }
        }
    }

    /**
     * 接口返回成功格式信息
     * @param array $items 数据数组
     * @param int $num_items 总数
     * @author: chenbo<chenb@51lick.cn>
     * @date: 2020/05/13
     * @version: v1.0.0
     * @since: 2020/05/13 09:05
     */
    public function returnSuccess($items = [], $num_items = 0) {
        header('content-type:application/json;charset=utf-8');
        $has_more = ($this->page+$this->count)>=$num_items?false:true;
        $rlt = [
            'has_more' => $has_more,
            'num_items' => $num_items,
            'items' => $items,
        ];
        LG::rest(0, $rlt);
    }

    /**
     * 接口返回错误格式信息
     * @param int $errorCode 错误码
     * @param string $errorMessage 错误内容
     * @author: chenbo<chenb@51lick.cn>
     * @date: 2020/05/13
     * @version: v1.0.0
     * @since: 2020/05/13 09:05
     */
    public function returnError($errorCode, $errorMessage) {
        header('content-type:application/json;charset=utf-8');
        LG::rest($errorCode, ['alert_msg' => $errorMessage]);
    }

}