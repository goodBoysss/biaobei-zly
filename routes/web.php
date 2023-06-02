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
    return "语音";
});

/**
 * API
 */
$router->group(['namespace' => 'Api', 'prefix' => 'api'], function ($router) {
    //生成声音
    $router->get('generate/sound', 'SoundController@generateSound');
});

/**
 * WEB
 */
$router->group(['namespace' => 'Web', 'prefix' => 'web'], function ($router) {
    //生成声音
    $router->get('sound', 'SoundController@generateSound');
});

