<?php

namespace App\Providers;

use App\Models\App;
use App\Models\Domain;
use App\Models\DomainRecentKey;
use App\Models\RedirectCover;
use App\Models\RedirectUrl;
use App\Models\RedirectVisitRecord;
use Illuminate\Support\ServiceProvider;

class ModelServiceProvider extends ServiceProvider
{
    public function register()
    {
        //应用
        $this->app();

        //域名
        $this->domain();

        //重定向跳转
        $this->redirect();
    }

    //应用
    private function app()
    {
        //应用
        $this->app->singleton('model_app', App::class);
    }

    //域名
    private function domain()
    {
        //域名
        $this->app->singleton('model_domain', Domain::class);
        //域名最近的一个key
        $this->app->singleton('model_domain_recent_key', DomainRecentKey::class);
    }

    //重定向跳转
    private function redirect()
    {
        //重定向url
        $this->app->singleton('model_redirect_url', RedirectUrl::class);
        //跳转封面图
        $this->app->singleton('model_redirect_cover', RedirectCover::class);
        //跳转访问日志
        $this->app->singleton('model_redirect_visit_record', RedirectVisitRecord::class);
    }
}
