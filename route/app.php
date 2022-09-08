<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;

Route::get('/', function () {
    return "create by 空子";
});

Route::group('admin', function () {
    Route::get('/', 'Admin/index');
});

Route::group('login', function () {
    Route::get('/', 'Login/index');
    Route::get('/out', 'Login/loginOut');
    Route::post('/login', 'Login/login');
    Route::post('/register', 'Login/register');
});