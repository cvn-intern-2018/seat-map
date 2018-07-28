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

// Route::get('/', function () {
//     return view('index');
// });
Route::get('/', 'HomeController@index')->name('home');
Route::get('/login', 'UserController@getLoginView')->name('login');
Route::get('/logout', 'UserController@logout')->name('logout');
Route::get('/test', 'SeatmapController@test');

Route::group(['middleware' => 'auth'], function(){
    Route::get('/seat-map/add', 'SeatmapController@getAddSeatmapPage');
    Route::post('/seat-map/add', 'SeatmapController@addSeatmapHandler');
});
Route::get('/add', 'UserController@addUserHandler')->name('adduser');
Route::get('/users', 'UserController@getusers')->name('getusers');
Route::post('/users', 'UserController@editUserHandler')->name('gett');
Auth::routes();