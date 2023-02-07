<?php

/**
 * UrlsAction
 * ==============================================
 * Copy right 2015-2017  by http://backend.51lick.com
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2017/6/15
 * @version: v2.0.0
 * @since: 2017/6/15 19:34
 */
namespace Controllers;

use Comments\BackendAction;
use LGCommon\module\HashIdsModule;
use LGCore\base\LG;
use Models\UrlsModel;
use Utils\BackendUtils;

class UrlsAction extends BackendAction
{

    /**
     * @var UrlsModel
     */
    private $urlsModel ;

    /**
     * UrlsAction constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->urlsModel = new UrlsModel();

    }

    /**
     * @methodName: goAction
     *
     * Enter description here ...
     *
     * @since File available since Version 1.0 ${DATE}
     * @author goen<goen88@163.com>
     * @return string
     */
    public function goAction() {
        $this->smarty->display('urls/urls.htm');
    }


    public function shortAddrsAction() {
        $this->smarty->display('urls/short_addrs.htm');
    }



    public function shortAddrAddAction() {
        if($this->check_post_method()){//添加信息
            $act = LG::reqeust()->getString('act');
//            var_export($_POST);exit;
            switch ($act){
                case "saveShortAddrInfo" : $this->_saveShortAddrInfo(); break;
            }
        }

        //默认数据
        $shortAddrInfo = [
            'id'=>0,
            'short_url'=>'',
            'status'=>1,
            'company_id'=>7235
        ];
        $this->smarty->assign('shortAddrInfo',$shortAddrInfo);
        $this->smarty->display('urls/short_addr_save.htm');

    }

    public function shortAddrEditAction() {
        if($this->check_post_method()){//编辑信息
            $act = LG::reqeust()->getString('act');
            //var_export($_POST);exit;
            switch ($act){
                case "saveShortAddrInfo" : $this->_saveShortAddrInfo(); break;
            }
        }
        $id = $this->backendParamCheck('id','int','ID',true);


        if($id>0){
            $shortAddrInfo = $this->urlsModel->shortAddrOne(['id'=>$id]);
            $this->smarty->assign('shortAddrInfo',$shortAddrInfo['items']);
        }

        $this->smarty->display('urls/short_addr_save.htm');

    }





    //**获取异步请求数据(ajax)******************************************************************************
    /**
     * 获取短链列表
     *
     * @since File available since Version 1.0 2019-5-6
     * @author gaorq
     * @return json
     */
    public function shortAddrsListAction(){
        $shortUrl = $this->backendParamCheck('short_url', "string", "短域名",false);
        $page = $this->backendParamCheck('page', "int", "页码",false);
        $count = $this->backendParamCheck('page_size', "int", "显示数量",false);
        $orderby = $this->backendParamCheck('orderby', "string", "排序",false);

        if($page<=0) {
            $page =1;
        }
        if($count==0) {
            $_REQUEST['page_size'] = 10;
            $count = 10;
        }
        $orderby = !empty($orderby)?$orderby:"id,desc";
        $where = array();
        if($shortUrl)$where['short_url']=$shortUrl;


//        if($group_id)$where['group_id']=$group_id;
//        if($username)$where['username']=$username;
//        if($truename)$where['truename']=$truename;

        $rlt = $this->urlsModel->shortAddrsList($where);


        $filter['record_count'] = $rlt['num_items'] ? $rlt['num_items'] : 0;
        $filter = BackendUtils::page_and_size($filter);

        $staffLists =  array('filter'=>$filter,'data'=>$rlt['items']?$rlt['items']:[]);
        exit(json_encode($staffLists));
    }


    public function urlsListAction(){
        $s_url = $this->backendParamCheck('s_url', "string", "短域名",true);

        $searchUrl = $this->backendParamCheck('search_url', "string", "URL",false);
        $searchSurl = $this->backendParamCheck('search_surl', "string", "短链接",false);
        $searchStatus = $this->backendParamCheck('search_status', "int", "状态",false);

        $page = $this->backendParamCheck('page', "int", "页码",false);
        $count = $this->backendParamCheck('page_size', "int", "显示数量",false);
        $orderby = $this->backendParamCheck('orderby', "string", "排序",false);

        if($page<=0) {
            $page =1;
        }
        if($count==0) {
            $_REQUEST['page_size'] = 10;
            $count = 10;
        }
        $orderby = !empty($orderby)?$orderby:"id,desc";
        $where = array();
        $where['s_url']  = $s_url;
        if($searchUrl!=='')$where['sha1']  = sha1($searchUrl);
        if($searchStatus!=='')$where['status']  = $searchStatus;
        //根据短url获取ID
        if($searchSurl!==''){
            $hash = new HashIdsModule();
            $urlArr = parse_url($searchSurl);
            if(isset($urlArr['path'])){
                $hashVal = trim($urlArr['path'],'/');
                $urlId = (int)$hash->decode($hashVal);
                if($urlId>0)$where['id']  = $urlId;
            }
        }
        $where['page']  = $page;
        $where['count']  = $count;

        $rlt = $this->urlsModel->urlsList($where);


        $filter['record_count'] = isset($rlt['num_items']) ? $rlt['num_items'] : 0;
        $filter = BackendUtils::page_and_size($filter);

        $staffLists =  array('filter'=>$filter,'data'=>isset($rlt['items'])?$rlt['items']:[]);
        exit(json_encode($staffLists));

    }

    public function urlStatusAction(){
        $shortUrl = $this->backendParamCheck('url', "string", "短链接",true);
        $status = $this->backendParamCheck('status', "int", "状态",true);

        $rlt =  $this->urlsModel->urlStatus([
            'url'=>$shortUrl
            ,'status'=>$status
        ]);
        if(!array_key_exists('error',$rlt)){
            echo json_encode(['msg'=>"更新成功"]);
        }else{
            echo json_encode($rlt);
        }
        exit();
    }


    //**私有方法******************************************************************************
    /**
     *
     * 保存短网址信息
     *
     * @date 2020/5/20 3:18 AM
     * @author goen<goen88@163.com>
     */
    private function _saveShortAddrInfo(){
        $id = $this->backendParamCheck('id', 'int', "ID",false);
        $companyId = $this->backendParamCheck('company_id', 'int', "企业",true);
        $shortUrl = $this->backendParamCheck('short_url', 'string', "短网址",true);
        $status = $this->backendParamCheck('status', 'int', "状态",false);

        $params=array(
            'company_id'  =>$companyId,
            'short_url'  =>$shortUrl,
            'status'  => $status,
        );

        if($id>0){//编辑
            $params['id'] =  $id;
        }else{ //添加
            //...
        }

        //保存操作
        $rlt = $this->urlsModel->saveShortAddr($params);

        if(!empty($rlt)&&!array_key_exists('error', $rlt)){
            $data = array(
                'type'=>'saveBaseinfo'
                ,'error'=>''
                ,'message'=>$id>0?'更新短网址信息成功':'添加短网址成功'
                ,'id'=>$rlt['id']
            );
        }else{
            $data = array(
                'type'=>'saveBaseinfo'
                ,'error'=>is_array($rlt)?$rlt:''
                ,'id'=>0
            );
        }

        exit(json_encode($data));
    }



}
