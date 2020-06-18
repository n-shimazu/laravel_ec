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
Route::get('/ec_tool', 'ecController@display_table');
Route::post('/insert', 'ecController@insert_item');
Route::delete('/ec_tool/delete/{item_id}', 'ecController@delete_item');
Route::put('/ec_tool/switch/{item_id}', 'ecController@switch_status');
Route::put('/ec_tool/update/{item_id}', 'ecController@update_stock');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/ec_index', 'ecController@display_open_items');
Route::post('/ec_index/add/{item_id}', 'CartsController@add');
Route::get('/ec_cart', 'CartsController@display_cart');
Route::put('/ec_cart/update/{item_id}', 'CartsController@update_amount');
Route::delete('/ec_cart/delete/{item_id}', 'CartsController@destroy_from_cart');
Route::post('/ec_finish', 'CartsController@purchase_item');
Route::get('/ec_result', 'ecController@display_results');
Route::get('/ec_detail/{result_id}', 'ecController@display_detail');