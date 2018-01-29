<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::group(['prefix' => 'nasabah', 'middleware' => ['auth']], function() {
    Route::get('/', 'NasabahController@index')->name('nasabah.index');
    Route::get('/list', 'NasabahController@list')->name('nasabah.list');
    Route::post('/', 'NasabahController@store')->name('nasabah.store');
    Route::get('/{no_rekening}', 'NasabahController@show')->name('nasabah.show');
    Route::get('/transaksi/{no_rekening}', 'NasabahController@listTransaksi')->name('transaksi.list');
    Route::post('{no_rekening}', 'NasabahController@setTransaksi')->name('nasabah.set-transaksi');
    Route::put('/update', 'NasabahController@update')->name('nasabah.update');
    Route::delete('/hapus', 'NasabahController@destroy')->name('nasabah.destroy');
});
