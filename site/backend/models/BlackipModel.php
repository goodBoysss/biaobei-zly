<?php
/**
 * BlackipModel.php
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


class BlackipModel extends BaseModel
{

    public function __construct()
    {
        parent::__construct();
    }



    public function blackipsList(array $params=[]): array {
        $rlt = $this->apiRequest('/blackip',$params);
        return $rlt;
    }


    public function save(array $params=[]): array {
        $rlt = $this->apiRequest('/blackip/save',$params,'post');
        return $rlt;
    }

    public function getOne(int $id): array {
        $params = ['id'=>$id];
        $rlt = $this->apiRequest('/blackip/one',$params,'post');
        return $rlt;
    }



    public function delete(array $params=[]): array {
        $rlt = $this->apiRequest('/blackip/delete',$params);
        return $rlt;
    }
}