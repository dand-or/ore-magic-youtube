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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return 'Hello world!';
});

Route::get('/hello/{name}', function ($name) {
    return 'Hello '.$name.'!';
});

Route::get('magic', 'App\Http\Controllers\MagicController@index');
Route::get('magic/download', 'App\Http\Controllers\MagicController@download');

// Route::resource('magic', 'App\Http\Controllers\MagicController');