<?php

namespace App\Providers;

use App\Repositories\AppRepository;
use App\Repositories\DomainRecentKeyRepository;
use App\Repositories\DomainRepository;
use App\Repositories\RedirectUrlRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        // 应用
        $this->app();

        // 域名
        $this->domain();

        //重定向跳转
        $this->redirect();
    }

    // 应用
    private function app()
    {
        // 应用
        $this->app->singleton('repo_app', AppRepository::class);
    }

    // 域名
    private function domain()
    {
        // 域名
        $this->app->singleton('repo_domain', DomainRepository::class);
        // 域名最近的一个key
        $this->app->singleton('repo_domain_recent_key', DomainRecentKeyRepository::class);
    }

    //重定向跳转
    private function redirect()
    {
        //重定向url
        $this->app->singleton('repo_redirect_url', RedirectUrlRepository::class);
    }
}
