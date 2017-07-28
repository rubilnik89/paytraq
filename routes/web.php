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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', 'PaytraqController@index')->name('register');
Route::get('/update_finans', 'PaytraqController@update_finans')->name('update_finans');
Route::get('/main', 'PaytraqController@main')->name('main');
Route::get('/group_products/{id}', 'PaytraqController@get_products_by_group')->name('group_products');
Route::get('/get_product/{id}', 'PaytraqController@get_product')->name('get_product');
