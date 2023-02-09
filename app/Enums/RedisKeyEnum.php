<?php

namespace App\Enums;

class RedisKeyEnum
{
    const APP = "shorturl:app"; //应用列表

    const SHORTEN_URL = 'shorturl:shorten:url:%s'; // 短链生成加锁


}
