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

Route::get('stock','Home\HomeController@stock');
Route::get('detail','Home\HomeController@detail');
Route::get('delete','Home\HomeController@delete');
Route::post('add','Home\HomeController@add');
Route::post('newstock','Home\HomeController@newstock');
