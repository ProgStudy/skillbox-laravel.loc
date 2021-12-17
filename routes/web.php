<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', 'HomeController@index');
Route::get('/about', 'HomeController@about');

Route::group(['prefix' => 'contacts'], function() {

    Route::get('/', 'HomeController@contacts');

    Route::group(['prefix' => 'ajax'], function() {
        Route::post('/send', 'HomeController@ajaxSendContact');
    });

});

Route::group(['prefix' => 'articles'], function() {
    Route::get('/{slug}', 'ArticleController@show');
    Route::get('/tags/{tag}', 'TagController@index');
});

Route::prefix('comments')->group(function () {
    Route::prefix('ajax')->group(function () {
        Route::get('/send', 'CommentController@store');
    });
});

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function(){
    Route::get('/',         'AdminController@index');
    Route::get('/feedback', 'AdminController@feedback');

    Route::resource('/articles', 'ArticleController');

});

Auth::routes();

//переопределить методы для работы с ajax запросами
Route::group(['namespace' => 'Auth'], function () {
    Route::post('/login',       ['uses' => 'LoginController@login'])->name('login');
    Route::post('/logout',      ['uses' => 'LoginController@logout'])->name('logout');
    Route::post('/register',    ['uses' => 'RegisterController@register'])->name('register');

    Route::prefix('password')->group(function () {
        Route::post('/email',       ['uses' => 'ForgotPasswordController@sendResetLinkEmail'])->name('password.email');
        Route::post('/reset',       ['uses' => 'ResetPasswordController@reset'])->name('password.update');
        Route::post('/confirm',     ['uses' => 'ConfirmPasswordController@confirm']);
    });
});
