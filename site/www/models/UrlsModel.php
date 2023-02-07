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


class UrlsModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }


    public function urlOne(array $params=[]): array {
        $rlt = $this->apiRequest('/urls/urlOne',$params);
        return $rlt;
    }


    /**
     *
     * 链接访问计数
     * @param array $params
     * @date 2020/6/28 3:57 下午
     * @return array
     * @author goen<goen88@163.com>
     */
    public function urlHits(array $params=[]): array {
        $rlt = $this->apiRequest('/urls/urlHits',$params);
        return $rlt;
    }

}