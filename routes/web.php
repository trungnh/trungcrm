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
    Route::post('/getCustomer', 'Admin\CustomerController@getCustomer')->name('customer.getCustomer');
    Route::get('/sample', 'Admin\SampleController@index')->name('sample.index');

    Route::get('/report', 'Admin\ReportController@index')->name('report.index');
    Route::get('/report/edit/{id}', 'Admin\ReportController@edit')->name('report.edit');
    Route::post('/report/addReport', 'Admin\ReportController@addReport')->name('report.addReport');
    Route::post('/report/saveReport/{id}', 'Admin\ReportController@saveReport')->name('report.saveReport');
    Route::get('/home/changeReportMonth/{month}', 'Admin\HomeController@changeReportMonth')->name('home.changeReportMonth');
});



