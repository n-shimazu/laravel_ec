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
Route::delete('/ec_tool/delete/{id}', 'ecController@delete_item');
Route::put('/ec_tool/switch/{id}', 'ecController@switch_status');
Route::put('/ec_tool/update/{id}', 'ecController@update_stock');

Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/ec_index', 'ecController@display_open_items');
