<?php
/**
 * BlackipListModel.php
 * ==============================================
 * Copy right 2014-2020  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2020/6/11
 * @version: v2.0.0
 * @since: 2020/6/11 10:52 上午
 */


namespace Models;


use LGCommon\data_data\lyx_blackip_list_data;

class BlackipListModel
{
    /**
     * @var lyx_blackip_list_data;
     */
    private $blackipListObj;

    public function __construct()
    {
        $this->blackipListObj = new lyx_blackip_list_data();
    }


    public function blackipList(array $where,$fields = "*",int $page=0,int $limit=10,array $orderby){
        $rlt = $this->blackipListObj->select_muti_num_and_rows($where,$fields,$page,$limit,$orderby);
        return $rlt;
    }

    /**
     *
     * 添加/更新数据
     * @param array $row_rec
     * @date 2020/6/11 1:12 下午
     * @return array|string[]
     * @author goen<goen88@163.com>
     */
    public function saveOne(array $row_rec){
        try{
            if(isset($row_rec['id'])&&(int)$row_rec['id']>0){
                $id=(int)$row_rec['id'];
                unset($row_rec['id']);
                $this->blackipListObj->update_a_row_by_id($row_rec,$id);
            }else{
                $id = $this->blackipListObj->insert_a_row($row_rec);
                if($id>0){
                    $row_rec['id'] = $id;
                    return  $row_rec;
                }else{
                    return ['error_code'=>'10040','error'=>'新增数据失败'];
                }
            }
        }catch (\Exception $e){
            return ['error_code'=>'10040','error'=>'保存数据异常'];
        }

    }

    /**
     *
     * 通过ID获取信息
     * @param int $id
     * @date 2020/6/15 8:36 上午
     * @return array|\LGCore\db\mysqli\MysqliDb|null
     * @author goen<goen88@163.com>
     */
    public function getOne(int $id){
        return $this->blackipListObj->select_row_by_id($id);
    }

    /**
     *
     * 通过IP获取信息
     * @param string $ip
     * @date 2020/6/16 4:33 下午
     * @author goen<goen88@163.com>
     */
    public function getOneByIp(string $ip){
        return $this->blackipListObj->select_row_by_ip($ip);
    }

    /**
     *
     * 删除ID
     *
     * @param $id
     * @date 2020/6/11 1:43 下午
     * @return int|string
     * @author goen<goen88@163.com>
     */
    public function deleteOne($id){
        return $this->blackipListObj->delete_a_row_by_id($id);
    }
}
