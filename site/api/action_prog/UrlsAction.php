<?php

/**
 * UrlsAction.php
 * ==============================================
 * Copy right 2015-2020  by http://backend.51lick.com
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date:  2020/5/18
 * @version: v2.0.0
 * @since: 2020/5/18 9:34 PM
 */
namespace Controllers;

use Comments\ApiAction;
use LGCore\base\LG;
use Models\ApiAuthorizeModel;
use Models\ShortAddrsModel;
use Models\UrlsModel;
use Utils\ApiUtils;

class UrlsAction extends ApiAction
{


    /**
     * @var UrlsModel|null
     */
    private $urlsModel = null;

    /**
     * @var ShortAddrsModel
     */
    private $shortAddrModel = null;

    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->urlsModel = new UrlsModel();

        $this->shortAddrModel = new ShortAddrsModel();
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
        LG::rest(10032, array('alert_msg'=>'Error:['.str_ireplace('_action', '',__CLASS__).'->'.str_replace( 'Action', '',__FUNCTION__).']不支持访问'));
    }

    /**
     *
     * 将url转短链接
     *
     * @date 2020/5/18 9:35 PM
     * @author goen<goen88@163.com>
     */
    public function shortenAction(){
        $url =  $this->apiParamCheck('url','string','url地址',true);
        $domain =  $this->apiParamCheck('domain','string','短域名地址',false);

        //生成短链接
        $rlt = $this->urlsModel->shortenUrl($url,$domain);

        if(!empty($rlt)&&!array_key_exists('error', $rlt)){
            $data = array(
                'has_more'=>false,
                'num_items'=>1,
                'items'=>$rlt
            );
            LG::rest(0, $data);
        }else{
            LG::rest($rlt['error_code'], array('alert_msg'=>$rlt['error']));
        }
    }


    /**
     *
     * 短网址批量生成
     *
     * @date 2020/5/26 5:37 PM
     * @author goen<goen88@163.com>
     */
    public function batchShortenAction(){
        $rawUrl =  $this->apiParamCheck('raw_url','string','url地址',true);
        $companyId =  $this->apiParamCheck('company_id','int','企业ID',false);
        //批量生成短链接
        $rlt = $this->urlsModel->batchShortenUrl($rawUrl,intval($companyId),$this->batchUrlsNum);

        if(!empty($rlt)&&!array_key_exists('error', $rlt)){
            $data = array(
                'has_more'=>false,
                'num_items'=>1,
                'items'=>$rlt
            );
            LG::rest(0, $data);
        }else{

            LG::rest($rlt['error_code'], array('alert_msg'=>$rlt['error']));
        }
    }

    /**
     *
     * 还原URL
     *
     * @date 2020/5/26 4:03 PM
     * @author goen<goen88@163.com>
     */
    public function expandAction(){
        $url =  $this->apiParamCheck('url','string','url地址',true);

        //还原短链接
        $rlt = $this->urlsModel->expandUrl($url);

        if(!empty($rlt)&&!array_key_exists('error', $rlt)){
            $data = array(
                'has_more'=>false,
                'num_items'=>1,
                'items'=>$rlt
            );
            LG::rest(0, $data);
        }else{
            LG::rest($rlt['error_code'], array('alert_msg'=>$rlt['error']));
        }
    }


    /**
     *
     * 获取短网址列表
     *
     * @date 2020/5/20 3:27 AM
     * @author goen<goen88@163.com>
     */
    public function shortAddrsListAction(){
        $shortUrl = $this->apiParamCheck('short_url', "string", "短域名",false);
        $companyId = $this->apiParamCheck('company_id', 'int', '企业ID', false);

        $whereArr = [];
        if ($shortUrl) $whereArr['short_url'] = array('like'=>"%{$shortUrl}%") ;
        if ($companyId) $whereArr['company_id'] = $companyId;
        $ret = $this->urlsModel->shortAddrsList($whereArr, '', $this->page, $this->count, ['id' => 'asc']);

        $this->returnSuccess($ret['items'], $ret['totalCount']);

    }


    /**
     *
     * 添加/修改短网址信息
     *
     * @date 2020/5/20 3:27 AM
     * @author goen<goen88@163.com>
     */
    public function saveShortAddrAction(){
        $id = $this->apiParamCheck('id', 'int', 'url地址', false);
        $shortUrl = $this->apiParamCheck('short_url', 'string', 'url地址', true);
        $companyId = $this->apiParamCheck('company_id', 'int', '企业ID', true);
        $status = $this->apiParamCheck('status', 'int', '状态', false);

        if($id>0){//编辑
            $rlt = $this->shortAddrModel->saveUrl($shortUrl,$companyId,$status,$id);
        }else{ //新增
            $rlt = $this->shortAddrModel->saveUrl($shortUrl,$companyId,$status);
        }



        if(!empty($rlt)&&!array_key_exists('error', $rlt)){
            $this->returnSuccess($rlt,1);
        }else{
            $this->returnError($rlt['error_code'],$rlt['error']);
        }

    }


    /**
     *
     * 获取短网址信息
     *
     * @date 2020/5/20 3:27 AM
     * @author goen<goen88@163.com>
     */
    public function shortAddrOneAction(){
        $id = $this->apiParamCheck('id', 'int', 'url地址', true);

        $rlt = $this->shortAddrModel->getOne($id);

        if(!empty($rlt)&&!array_key_exists('error', $rlt)){
            $this->returnSuccess($rlt,1);
        }else{
            $this->returnError($rlt['error_code'],$rlt['error']);
        }

    }

    /**
     *
     * 获取短链接列表
     *
     * @date 2020/6/8 12:44 下午
     * @throws \Exception
     * @author goen<goen88@163.com>
     */
    public function urlsListAction(){
        $s_url = $this->apiParamCheck('s_url', 'string', '短域名', false);
        $sha1 = $this->apiParamCheck('sha1', 'string', '原始域名', false);
        $status = $this->apiParamCheck('status', 'string', '状态', false);
        $id = $this->apiParamCheck('id', 'int', 'ID', false);

        $whereArr = [];
        if($sha1!=='') $whereArr['sha1'] = $sha1;
        if($status!=='') $whereArr['status'] = $status;
        if($id>0) $whereArr['id'] = $id;
        $ret = $this->urlsModel->urlsList($s_url,$whereArr, '', $this->page, $this->count, ['id' => 'asc']);

        $this->returnSuccess($ret['items'], $ret['totalCount']);
    }


    /**
     *
     * 获取单个链接地址
     *
     * @date 2020/6/9 8:20 下午
     * @author goen<goen88@163.com>
     */
    public function urlOneAction(){
        $url = $this->apiParamCheck('url', 'string', '短链接地址', true);

        $rlt = $this->urlsModel->urlOne($url);

        if(!empty($rlt)&&!array_key_exists('error', $rlt)){
            $this->returnSuccess($rlt,1);
        }else{
            $this->returnError($rlt['error_code'],$rlt['error']);
        }
    }


    /**
     *
     * 修改短链接的状态
     *
     * @date 2020/6/9 8:20 下午
     * @author goen<goen88@163.com>
     */
    public function urlStatusAction(){
        $url = $this->apiParamCheck('url', 'string', '短链接地址', true);
        $status = $this->apiParamCheck('status', 'string', '状态', true);

        $rlt = $this->urlsModel->changeStatus($url,$status);

        if(!empty($rlt)&&!array_key_exists('error', $rlt)){
            $this->returnSuccess($rlt,1);
        }else{
            $this->returnError($rlt['error_code'],$rlt['error']);
        }
    }

    /**
     *
     * 短链接点击计数
     *
     * 2020/6/28 3:40 下午
     * @author goen<goen88@163.com>
     */
    public function urlHitsAction(){
        $url = $this->apiParamCheck('url', 'string', '短链接地址', true);

        $rlt = $this->urlsModel->updateHits($url);

        if(!empty($rlt)&&!array_key_exists('error', $rlt)){
            $this->returnSuccess($rlt,1);
        }else{
            $this->returnError($rlt['error_code'],$rlt['error']);
        }
    }



    /**
     *
     * 获取可用的短网址
     *
     * @date 2020/6/10 2:46 下午
     * @author goen<goen88@163.com>
     */
    public  function domainsAction(){
        $company_id = $this->apiParamCheck('company_id', 'int', '企业ID', false);
        if(empty($company_id)){
            $company_id = 0;
        }
        $rlt = $this->urlsModel->getSupportDomains($company_id);

        $this->returnSuccess($rlt,1);
    }

}
