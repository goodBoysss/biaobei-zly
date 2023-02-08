<?php


namespace App\Providers;


use App\Logics\RedirectLogic;
use App\Logics\UrlLogic;
use Illuminate\Support\ServiceProvider;

class LogicServiceProvider extends ServiceProvider
{
    //register
    public function register()
    {
        //缓存业务数据
        $this->cache();
        //短链接处理
        $this->url();
        //重定向url
        $this->redirect();

    }

    //缓存业务数据
    public function cache()
    {
        //缓存-应用
        $this->app->singleton('logic_cache_app', \App\Logics\Cache\AppLogic::class);
    }

    //短链接处理
    public function url()
    {
        //缓存-链接
        $this->app->singleton('logic_url', UrlLogic::class);
    }

    //重定向url
    public function redirect()
    {
        //缓存-链接
        $this->app->singleton('logic_redirect', RedirectLogic::class);
    }

}