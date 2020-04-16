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

Route::group(['middleware'=>'guest'], function()
{
  Route::get('/login', 'MainController@login')->name('login');
  Route::post('/masuk', 'MainController@loginProcess')->name('login.process');
});

Route::group(['middleware'=>'auth'], function()
{
  Route::get('/', 'MainController@index')->name('home');

  Route::get('/keluar', 'MainController@logout')->name('logout');

  Route::get('/pengaturan', 'MainController@sysConf')->name('configs');
  Route::post('pengaturan', 'MainController@sysConfUpdate')->name('configs.update');

  Route::get('/pengaturan/akun', 'MainController@profile')->name('profile');
  Route::post('/pengaturan/akun', 'MainController@profileUpdate')->name('profile.update');

  Route::get('/pengaturan/hapus-img/{img}', 'MainController@deleteImg')->name('configs.delete.img');
  Route::get('/pengaturan/cetakqr', 'MainController@printQR')->name('configs.print.qr');

  Route::group(['prefix'=>'ajax'], function()
  {
    Route::get('/instansi', 'AjaxController@searchInstansi')->name('ajax.instansi');
  });

  Route::group(['prefix'=>'guest'], function()
  {
    Route::get('/', 'GuestController@index')->name('guest.index');
    Route::post('/show', 'GuestController@show')->name('guest.show');
  });

  Route::group(['middleware'=>'roles:admin'], function()
  {
    Route::group(['prefix'=>'instansi'], function()
    {
      Route::get('/', 'InstansiController@index')->name('instansi.index');
      Route::get('/tambah', 'InstansiController@create')->name('instansi.create');
      Route::post('/tambah', 'InstansiController@store')->name('instansi.store');
      Route::get('/ubah/{uuid}', 'InstansiController@edit')->name('instansi.edit');
      Route::post('/ubah/{uuid}', 'InstansiController@update')->name('instansi.update');
      Route::get('/hapus/{uuid}', 'InstansiController@destroy')->name('instansi.destroy');
    });

    Route::group(['prefix'=>'pengguna'], function()
    {
      Route::get('/', 'UsersController@index')->name('users.index');
      Route::get('/tambah', 'UsersController@create')->name('users.create');
      Route::post('/tambah', 'UsersController@store')->name('users.store');
      Route::get('/ubah/{uuid}', 'UsersController@edit')->name('users.edit');
      Route::post('/ubah/{uuid}', 'UsersController@update')->name('users.update');
      Route::get('/hapus/{uuid}', 'UsersController@destroy')->name('users.destroy');
    });
  });

});
