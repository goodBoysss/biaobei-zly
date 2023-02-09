<?php

namespace App\Enums;

class RedisKeyEnum
{
    const APP = "shorturl:app"; //应用列表

    const SHORTEN_URL = 'shorturl:shorten:url:%s'; // 短链生成加锁

    const REDIRECT_URLS = 'shorturl:redirect:domain:%s:%s'; // 重定向跳转地址

    const REDIRECT_VISIT_RECORD = 'shorturl:redirect:visit:record'; // 跳转访问记录

}
