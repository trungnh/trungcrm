<?php

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

use \Illuminate\Support\Facades\Route;

// Refer: \Illuminate\Routing\Router::auth
// Auth::routes(['register' => false, 'reset' => false, 'confirm' => false, 'verify' => false]);

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

Route::middleware('auth')->group(function () {
    Route::get('/', 'Admin\HomeController@index')->name('admin.index');
    Route::get('/product', 'Admin\ProductController@index')->name('product.index');
    Route::post('/addProduct', 'Admin\ProductController@addProduct')->name('product.addProduct');
    Route::get('/order', 'Admin\OrderController@index')->name('order.index');
    Route::post('/addOrder', 'Admin\OrderController@addOrder')->name('order.addOrder');
    Route::get('/sample', 'Admin\SampleController@index')->name('sample.index');

    Route::get('/bm', 'Admin\BmController@index')->name('bm.index');
    Route::get('/bm/edit/{id}', 'Admin\BmController@edit')->name('bm.edit');
    Route::post('/saveBm', 'Admin\BmController@saveBm')->name('bm.saveBm');
    Route::post('/removeBm', 'Admin\BmController@removeBm')->name('bm.removeBm');
    Route::post('/addBm', 'Admin\BmController@addBm')->name('bm.addBm');
    Route::get('/ad-account', 'Admin\BmController@adAccount')->name('bm.ad_account');
    Route::get('/reloadAccount', 'Admin\BmController@reloadAccount')->name('bm.reloadAccount');
    Route::get('/test', 'Admin\BmController@test')->name('bm.test');

    Route::get('/camp', 'Admin\BmController@camp')->name('bm.camp');
    Route::post('/getCampData', 'Admin\BmController@getCampData')->name('bm.getCampData');
});



