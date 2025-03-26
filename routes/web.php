<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// 메인 페이지
Route::controller(\App\Http\Controllers\MainController::class)->group(function() {
    Route::get('/', 'main')->name('main');
});

// 로그인
Route::middleware('guest')->prefix('auth')->controller(\App\Http\Controllers\AuthController::class)->group(function() {
    Route::post('login', 'loginProcess')->name('loginProcess');
});

// 로그아웃
Route::middleware('auth:admin,web')->prefix('auth')->controller(\App\Http\Controllers\AuthController::class)->group(function() {
    Route::get('logout', 'logoutProcess')->name('logoutProcess');
});

// 행사관리
Route::prefix('event')->controller(\App\Http\Controllers\Event\EventController::class)->group(function() {
    
    Route::middleware('auth:admin')->group(function(){
        Route::get('/list', 'list')->name('event.list');
        Route::get('/regist', 'form')->name('event.form');
        Route::post('/regist', 'upsert')->name('event.upsert');
    });

    Route::middleware('auth:web', 'myEvent')->group(function(){
        Route::get('/', 'intro')->name('event.intro');
    });
});

Route::controller(\App\Http\Controllers\Controller::class)->prefix('common')->group(function () {       
    /*
     * File Download URL
     * type => only: 단일, zip: 일괄다운(zip)
     * tbl => 테이블
     * sid => sid 값 enCryptString(sid) 로 암호화해서 전송
     */
    Route::get('fileDownload/{type}/{tbl}/{sid}', 'fileDownload')->where('type', 'only|zip')->name("download");
    Route::post('/tinyUpload', 'tinyUpload')->name("tinyUpload");
    Route::post('/plUpload', 'plUpload')->name("plUpload");
});