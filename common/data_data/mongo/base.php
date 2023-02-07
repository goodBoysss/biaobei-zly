<?php
/**
 * base.php
 * ==============================================
 * Copy right 2014-2019  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2019/6/19
 * @version: v2.0.0
 * @since: 2019/6/19 3:15 PM
 */


namespace LGCommon\data_data\mongo;


use LGCore\base\LG;

class base
{

    /**
     * 表(集合)名称
     * @var string
     */
    protected $collection='test';

    /**
     * @var \MongoDB\Collection
     */
    protected $collectionObj;

    public function __construct()
    {
        $client = LG::getMongoDB();
        if($client){
            $this->collectionObj = $client->{LG_MONGODB_NAME}->{$this->collection};
        }else{
            throw new \Exception('MongoDD connect refuesd.');
        }
    }


    /**
     * 插入单条数据
     *
     * @param array $document
     * @param array $options
     * @date 2019/6/20 9:20 AM
     * @author goen<goen88@163.com>
     * @return mixed
     * @example
     *  $insertOneResult = $collection->insertOne([
     *       'username' => 'admin',
     *       'email' => 'admin@example.com',
     *       'name' => 'Admin User',
     *   ]);
     * @inheritdoc
     *  https://docs.mongodb.com/php-library/current/reference/method/MongoDBCollection-insertOne/#phpmethod.MongoDB\Collection::insertOne
     */
    public function insertOne($document,$options=[]){
        $rlt = $this->collectionObj->insertOne($document,$options);
        return $rlt->getInsertedId();
    }

    /**
     *
     * 批量插入数据
     *
     * @param $document
     * @param array $options
     * @date 2019/6/20 9:24 AM
     * @author goen<goen88@163.com>
     * @return array
     * @example
     *  $insertManyResult = $collection->insertMany([
     *       [
     *           'username' => 'admin',
     *           'email' => 'admin@example.com',
     *           'name' => 'Admin User',
     *       ],
     *       [
     *           'username' => 'test',
     *           'email' => 'test@example.com',
     *           'name' => 'Test User',
     *       ],
     *   ]);
     * @inheritdoc
     * https://docs.mongodb.com/php-library/current/reference/method/MongoDBCollection-insertMany/#phpmethod.MongoDB\Collection::insertMany
     */
    public function insertMany($document,$options=[]){
        $rlt = $this->collectionObj->insertMany($document,$options);

        return [
            'ids'=>$rlt->getInsertedIds(),
            'count'=>$rlt->getInsertedCount()
        ];
    }


    /**
     *
     * 更新单条数据
     *
     * @param array $filter 过滤条件
     * @param array $update 更新数据
     * @param array $options 配置项
     * @date 2019/6/24 5:51 PM
     * @author goen<goen88@163.com>
     * @return array
     * @example
     *  $updateResult = $collection->updateOne(
     *       ['state' => 'ny'],
     *       ['$set' => ['country' => 'us']]
     *   );
     * @inheritdoc
     *  https://docs.mongodb.com/php-library/current/reference/method/MongoDBCollection-updateOne/#phpmethod.MongoDB\Collection::updateOne
     */
    public function updateOne($filter,$update,$options=[]){
        $rlt = $this->collectionObj->updateOne($filter,$update,$options);

        return [
            'mached_count'=>$rlt->getMatchedCount(),
            'modified_count'=>$rlt->getModifiedCount()
        ];
    }

    /**
     *
     * 批量更新数据
     * @param array $filter 过滤条件
     * @param array $update 更新数据
     * @param array $options 配置项
     * @date 2019/6/24 5:49 PM
     * @author goen<goen88@163.com>
     * @return array
     * @example
     *  $updateResult = $collection->updateMany(
     *           ['state' => 'ny'],
     *           ['$set' => ['country' => 'us']]
     *       );
     * @inheritdoc
     *  https://docs.mongodb.com/php-library/current/reference/method/MongoDBCollection-updateMany/#phpmethod.MongoDB\Collection::updateMany
     */
    public function updateMany($filter,$update,$options=[]){
        $rlt = $this->collectionObj->updateMany($filter,$update,$options);

        return [
            'matched_count'=>$rlt->getMatchedCount(),
            'modified_count'=>$rlt->getModifiedCount()
        ];
    }

    /**
     *
     * 删除单条数据
     *
     * @param array $filter 过滤条件
     * @param array $options 配置项
     * @date 2019/6/24 5:48 PM
     * @author goen<goen88@163.com>
     * @return int
     * @example
     *  $rlt = $collection->deleteOne(['state' => 'ny']);
     * @inheritdoc
     *  https://docs.mongodb.com/php-library/current/reference/method/MongoDBCollection-deleteOne/#phpmethod.MongoDB\Collection::deleteOne
     */
    public function deleteOne($filter,$options=[]){
       $rlt = $this->collectionObj->deleteOne($filter,$options);
       return $rlt->getDeletedCount();
    }

    /**
     *
     * 批量删除数据
     *
     * @param array $filter 过滤条件
     * @param array $options 配置项
     * @date 2019/6/24 5:48 PM
     * @author goen<goen88@163.com>
     * @return int
     *
     * @example
     *  $deleteResult = $collection->deleteMany(['state' => 'ny']);
     * @inheritdoc
     *  https://docs.mongodb.com/php-library/current/reference/method/MongoDBCollection-deleteMany/#phpmethod.MongoDB\Collection::deleteMany
     */
    public function deleteMany($filter,$options=[]){
        $rlt = $this->collectionObj->deleteMany($filter,$options);
        return $rlt->getDeletedCount();
    }

    /**
     *
     * 查询单条数据
     *
     * @param array $filter 过滤条件
     * @param array $options 配置项
     * @date 2019/6/24 5:47 PM
     * @author goen<goen88@163.com>
     * @return array|null|object
     * @example
     *      $document = $dataObj->findOne(['_id' => '94301']);
     * @inheritdoc
     *  https://docs.mongodb.com/php-library/current/reference/method/MongoDBCollection-findOne/#phpmethod.MongoDB\Collection::findOne
     */
    public function findOne($filter,$options=[]){
        $rlt = $this->collectionObj->findOne($filter,$options);
        return $rlt;
    }


    /**
     *
     * 查询多条数据
     *
     * @param array $filter 过滤条件
     * @param array $options 配置项
     * @date 2019/6/24 5:37 PM
     * @author goen<goen88@163.com>
     * @return array
     * @example
     *  $cursor = $dataObj->findMany(
     *       [
     *           'cuisine' => 'Italian',
     *          'borough' => 'Manhattan',
     *       ],
     *       [
     *           'projection' => [
     *           'name' => 1,
     *           'borough' => 1,
     *           'cuisine' => 1,
     *       ],
     *       'limit' => 4,
     *       'skip' => 100,
     *       ]
     *    );
     * @inheritdoc
     *  https://docs.mongodb.com/php-library/current/reference/method/MongoDBCollection-find/
     */
    public function findMany($filter=[],$options=[]){
        $cursor = $this->collectionObj->find($filter,$options);
        $rlt = [];
        foreach ($cursor as $document) {
            $rlt[] = $document;
        }
        return $rlt;
    }


    /**
     *
     * Enter description here ...
     * * @param array $pipeline
     * @param array $options
     * @date 2019/6/24 6:15 PM
     * @author goen<goen88@163.com>
     * @return array
     * @example
     *  $cursor = $collection->aggregate([
     *               ['$group' => ['_id' => '$state', 'count' => ['$sum' => 1]]],
     *               ['$sort' => ['count' => -1]],
     *               ['$limit' => 5],
     *           ]);
     * @inheritdoc
     *  https://docs.mongodb.com/php-library/current/reference/method/MongoDBCollection-aggregate/#phpmethod.MongoDB\Collection::aggregate
     *
     */
    public function aggregate(array $pipeline, array $options = []){
        $cursor = $this->collectionObj->aggregate($pipeline,$options);
        $rlt = [];
        foreach ($cursor as $docment) {
            $rlt[] = $docment;
        }
        return $rlt;
    }



}