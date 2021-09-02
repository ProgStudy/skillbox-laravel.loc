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

Route::group(['prefix' => 'admin'], function(){
    Route::get('/',         'AdminController@index');
    Route::get('/feedback', 'AdminController@feedback');

    Route::resource('/articles', 'ArticleController');

});
