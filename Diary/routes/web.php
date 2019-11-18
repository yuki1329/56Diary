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
//     return view('welcome');
// });
//('このURLの時' , 'このコントローラー@メソッド')
Route::get('/','DiaryController@index')->name('diary.index');

Auth::routes();
Route::group(['middleware'=>['auth']],function()
{
  //この中に書かれたルートはログインしないと見れなくなる
  Route::get('/diary/create','DiaryController@create')->name('diary.create');
Route::post('/diary/store','DiaryController@store')->name('diary.store');  //自分のすきな名前を入れていいよ
 //delete.blade.php
Route::delete('/diary/{id}','DiaryController@destroy')->name('diary.destroy');
 //edit.blade.php
Route::get('/diary/{id}/edit','DiaryController@edit')->name('diary.edit');
Route::put('/diary/{id}/update','DiaryController@update')->name('diary.update');
});
