<?php

/**
 * HashIdsModule.php
 * ==============================================
 * Copy right 2014-2020  by Gaorrunqiao
 * ----------------------------------------------
 * This is not a free software, without any authorization is not allowed to use and spread.
 * ==============================================
 * @desc :
 * @author: goen<goen88@163.com>
 * @date: 2020/5/18
 * @version: v2.0.0
 * @since: 2020/5/18 9:57 PM
 */

namespace LGCommon\module;

use Hashids\Hashids;
use LGCore\base\LG;

class HashIdsModule
{

    private $hashids;

    public function __construct(array $params=[])
    {
        $this->hashids = new Hashids(
            LG::$params['hashIds']['salt'],
            LG::$params['hashIds']['length'],
            LG::$params['hashIds']['alphabet']
        );
    }

    public function encode($id)
    {
        return $this->hashids->encode($id);
    }

    public function decode($hash)
    {
        $id = $this->hashids->decode($hash);

        return $id ? $id[0] : false;
    }

}