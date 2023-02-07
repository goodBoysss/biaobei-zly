<?php
/**
 * UrlsModel.php
 * ==============================================
 * Copy right 2014-2020  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2020/5/19
 * @version: v2.0.0
 * @since: 2020/5/19 9:12 PM
 */


namespace Models;


use LGCore\base\LG;
use LGCore\db\mysqli\MysqliDb;

class UrlsModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }




    public function shortAddrsList(array $params=[]): array {
        $rlt = $this->apiRequest('/urls/shortAddrsList',$params);
        return $rlt;
    }


    public function saveShortAddr(array $params=[]): array {
        $rlt = $this->apiRequest('/urls/saveShortAddr',$params,"post");
        return $rlt;
    }


    public function shortAddrOne(array $params=[]): array {
        $rlt = $this->apiRequest('/urls/shortAddrOne',$params);
        return $rlt;
    }


    public function urlStatus(array $params=[]): array {
        $rlt = $this->apiRequest('/urls/urlStatus',$params);
        return $rlt;
    }


    public function urlsList(array $params=[]): array {
        $rlt = $this->apiRequest('/urls/urlsList',$params);
        return $rlt;
    }


}