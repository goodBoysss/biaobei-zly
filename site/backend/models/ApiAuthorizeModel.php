<?php
/**
 * ApiAuthorizeModel.php
 * ==============================================
 * Copy right 2014-2020  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2020/6/11
 * @version: v2.0.0
 * @since: 2020/6/11 7:30 下午
 */


namespace Models;


class ApiAuthorizeModel extends BaseModel
{

    public function __construct()
    {
        parent::__construct();
    }


    public function apiAuthorizeList(array $params=[]): array {
        $rlt = $this->apiRequest('/apiAuthorize',$params);
        return $rlt;
    }


    public function save(array $params=[]): array {
        $rlt = $this->apiRequest('/apiAuthorize/save',$params,'post');
        return $rlt;
    }

    public function getOne(int $id): array {
        $params = ['id'=>$id];
        $rlt = $this->apiRequest('/apiAuthorize/one',$params,'post');
        return $rlt;
    }


    public function refreshSK(array $params=[]): array {
        $rlt = $this->apiRequest('/apiAuthorize/refreshSK',$params);
        return $rlt;
    }

    public function delete(array $params=[]): array {
        $rlt = $this->apiRequest('/apiAuthorize/delete',$params);
        return $rlt;
    }
}