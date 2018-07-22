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
Route::get('/', 'UserController@index')->name('home');
Route::get('/dashboard', 'AdminController@index')->name('dashboard')->middleware('auth');
Route::get('/login', 'UserController@getLoginView')->name('login');
Route::get('/logout', 'AdminController@logout')->name('logout');
Route::post('/authenticate', 'UserController@login')->name('auth');
Route::get('/set-seat', function(){
    return view('admin.add-user-seat');
});

Auth::routes();