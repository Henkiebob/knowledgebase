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

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/products', 'ProductsController@index')->name('products');

Route::get('/products/new', 'ProductsController@create')->name('create-product');
Route::post('products/new', 'ProductsController@store');

Route::get('/products/{id}/edit', 'ProductsController@edit')->name('edit-product');
Route::put('/products/{id}/edit', 'ProductsController@update');

Route::get('/products/{id}/delete', 'ProductsController@delete')->name('delete-product');
Route::delete('/products/{id}/delete', 'ProductsController@destroy')->name('delete-product');

Auth::routes();

Route::get('/home', 'HomeController@index');
