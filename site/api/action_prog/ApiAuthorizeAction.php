<?php
/**
 * ApiAuthorizeAction.php
 * ==============================================
 * Copy right 2014-2020  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2020/6/11
 * @version: v2.0.0
 * @since: 2020/6/11 9:28 上午
 */


namespace Controllers;


use Comments\ApiAction;
use LGCore\base\LG;
use Models\ApiAuthorizeModel;

class ApiAuthorizeAction extends ApiAction
{

    /**
     * @var ApiAuthorizeModel
     */
    private $apiAuthorizeModel;

    public function __construct()
    {
        parent::__construct();

        $this->apiAuthorizeModel = new ApiAuthorizeModel();
    }

    /**
     *
     * 获取授权信息列表
     *
     * @date 2020/6/11 9:28 上午
     * @author goen<goen88@163.com>
     */
    public function goAction(){
        $name = $this->apiParamCheck('name','string','授权名称',false);
        $status = $this->apiParamCheck('status','int','状态',false);

        $where = [];
        if($name!=='') $where['name'] = ['like'=>"%{$name}%"];
        if($status!=='') $where['status'] = $status;
        $orderby = ['id'=>'desc'];
        $rlt = $this->apiAuthorizeModel->apiAuthorizeList($where,"*",$this->page,$this->count,$orderby);

        $this->returnSuccess(
            isset($rlt['items'])?$rlt['items']:[],
            isset($rlt['totalCount'])?$rlt['totalCount']:$rlt['totalCount']
        );
    }

    /**
     *
     * 保存/修改授权信息
     *
     * @date 2020/6/11 9:28 上午
     * @author goen<goen88@163.com>
     */
    public function saveAction(){
        //设置为post请求
        $this->check_post_method();
        $id = $this->apiParamCheck('id','int','ID',false);
        $name = $this->apiParamCheck('name', 'string', "授权名称",true);
        $company_id = $this->apiParamCheck('company_id', 'int', "公司ID",true);
        $rate_minute = $this->apiParamCheck('rate_minute', 'int', "每分钟请求速率",true);
        $rate_hour = $this->apiParamCheck('rate_hour', 'int', "每小时请求速率",true);
        $rate_day = $this->apiParamCheck('rate_day', 'int', "每天请求速率",true);
        $rate_month = $this->apiParamCheck('rate_month', 'int', "每月请求速率",true);
        $batch_num = $this->apiParamCheck('batch_num', 'int', "单次最大生成数",true);
        $access_type = $this->apiParamCheck('access_type', 'int', "请求访问类型",true);
        $status = $this->apiParamCheck('status', 'int', "状态",false);
        $expire = $this->apiParamCheck('expire', 'datetime', "有效期",false);
        $white_list = $this->apiParamCheck('white_list', 'string', "白名单",false);


        $row_rec = [];
        if($id!==''&&!empty($id)) $row_rec['id'] = $id;
        if($name!=='') $row_rec['name'] = $name;
        if($company_id!=='') $row_rec['company_id'] = $company_id;
        if($rate_minute!=='') $row_rec['rate_minute'] = $rate_minute;
        if($rate_hour!=='') $row_rec['rate_hour'] = $rate_hour;
        if($rate_day!=='') $row_rec['rate_day'] = $rate_day;
        if($rate_month!=='') $row_rec['rate_month'] = $rate_month;
        if($batch_num!=='') {
            $row_rec['batch_num'] = $batch_num;
        }else{
            $row_rec['batch_num'] = 100;
        }
        if($access_type!=='') $row_rec['access_type'] = $access_type;
        if($expire!=='') {
            $row_rec['expire'] = $expire;
        }else{
            $row_rec['expire'] = '';
        }
        if($white_list!=='') $row_rec['white_list'] = $white_list;

        if($status!==''){
            $row_rec['status'] = $status;
        }else{
            $row_rec['status'] = 0;
        }


        if(empty($row_rec)){
            $this->returnError('100012',"保存信息不能为空");
        }
        $rlt = $this->apiAuthorizeModel->saveOne($row_rec);


        $this->returnSuccess($rlt,1);
    }


    /**
     *
     * 通过ID获取授权信息
     * @date 2020/6/15 8:38 上午
     * @author goen<goen88@163.com>
     */
    public function oneAction(){
        $id = $this->apiParamCheck('id','int','ID',true);
        $rlt = $this->apiAuthorizeModel->getOne($id);
        $this->returnSuccess($rlt,1);
    }

    /**
     *
     * 更新Secret Key
     *
     * @date 2020/6/16 11:37 上午
     * @author goen<goen88@163.com>
     */
    public function refreshSKAction(){
        $id = $this->apiParamCheck('id','int','ID',true);
        $rlt = $this->apiAuthorizeModel->refreshSK($id);

        if($rlt){
            $this->returnSuccess($rlt,1);
        }else{
            $this->returnError(100040,"更新失败");
        }
    }

    /**
     *
     * 删除授权信息
     *
     * @date 2020/6/11 9:28 上午
     * @author goen<goen88@163.com>
     */
    public function deleteAction(){

    }

}