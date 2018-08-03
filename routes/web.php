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
Route::get('/seat-map/{id}', 'SeatmapController@getSeatmapDetail')->name('seatmapDetail');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'permission'], function(){
        Route::post('/seat-map/add', 'SeatmapController@addSeatmapHandler');
        Route::get('/seat-map/edit/{id}', 'SeatmapController@getEditSeatmapPage');
        Route::post('/seat-map/delete', 'SeatmapController@deleteSeatmapHandler');
        Route::post('/seat-map/edit/', 'SeatmapController@updateEditingSeatmap')->name("seatmapEditHandler");
    });
});

Route::get('/users', 'UserController@getUsers');
Route::get('/users/delete/{name}', 'UserController@deleteUserHandler')->name('delete');
Route::post('/users/edit', 'UserController@editUserHandler')->name('edit');
Route::post('/users/add', 'UserController@addUserHandler')->name('add');
Auth::routes();