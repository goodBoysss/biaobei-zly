<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/**
 * @var Laravel\Lumen\Routing\Router $router
 */
$router->get('/', function () use ($router) {
    return "短链接服务";
});

/**
 * API
 */
$router->group(['namespace' => 'Api', 'prefix' => 'api'], function ($router) {
    /**
     * 生成链接
     */
    $router->group(['prefix' => 'url', 'middleware' => ['app']], function ($router) {
        //生成单个短链接
        $router->post('/shorten', 'UrlController@shortenUrl');
        //批量生成短链接
        $router->post('/batch/shorten', 'UrlController@batchShortenUrl');
    });

});

//重定向链接url
$router->get('/{shortUrl}', 'Redirect\RedirectController@redirectUrl');



