<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {

    //Route::get('/', 'Home\IndexController@index');
    //Route::get('/cate/{cate_id}', 'Home\IndexController@cate');
    //Route::get('/a/{art_id}', 'Home\IndexController@article');

    Route::any('admin/login', 'Admin\LoginController@login');
    Route::get('admin/code', 'Admin\LoginController@code');
});

Route::group(['middleware' => ['web'],'prefix'=>'api','namespace'=>'Api'], function () {
    Route::get('/notice/list', 'ApiController@noticeList');
    Route::get('/notice/{id}', 'ApiController@noticeDetail');
    Route::get('/news/list', 'ApiController@newsList');
    Route::get('/news/{id}', 'ApiController@newsDetail');
    Route::get('/culture/list', 'ApiController@cultureList');
    Route::get('/culture/{id}', 'ApiController@cultureDetail');
    Route::get('/baike/list', 'ApiController@baikeList');
    Route::get('/baike/{id}', 'ApiController@baikeDetail');
    Route::get('/convenience/list', 'ApiController@convenienceList');
    Route::get('/convenience/{id}', 'ApiController@convenienceDetail');

    //智慧商圈
    Route::get('/business/sub', 'ApiController@businessSub');//子类
    Route::get('/business/sub/list/{id}', 'ApiController@businessSubList');//子类列表
    Route::get('/business/sub/detail/{id}', 'ApiController@businessSubDetail');//子类

    //广告
    Route::get('/ad/lunbo', 'ApiController@adLunbo');//轮播
    Route::get('/ad/list/{cate_id}', 'ApiController@adList');//列表页广告
    Route::get('/ad/text', 'ApiController@adText');//文字广告
});


Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::get('index', 'IndexController@index');
    Route::get('info', 'IndexController@info');
    Route::get('quit', 'LoginController@quit');
    Route::any('pass', 'IndexController@pass');

    Route::post('cate/changeorder', 'CategoryController@changeOrder');
    Route::resource('category', 'CategoryController');

    Route::resource('article', 'ArticleController');

    Route::post('links/changeorder', 'LinksController@changeOrder');
    Route::resource('links', 'LinksController');

    Route::post('navs/changeorder', 'NavsController@changeOrder');
    Route::resource('navs', 'NavsController');

    Route::get('config/putfile', 'ConfigController@putFile');
    Route::post('config/changecontent', 'ConfigController@changeContent');
    Route::post('config/changeorder', 'ConfigController@changeOrder');
    Route::resource('config', 'ConfigController');

    Route::any('upload', 'CommonController@upload');
    Route::any('cache/clear', 'CommonController@cacheClear');

    Route::resource('ad', 'AdController');

});