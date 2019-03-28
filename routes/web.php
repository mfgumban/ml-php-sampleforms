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

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/feedback', 'FeedbackController@index')->name('feedback')->middleware('guest');
Route::post('/feedback', 'FeedbackController@submit');
Route::get('/feedback-done', 'FeedbackController@done')->name('feedback-done')->middleware('guest');

Route::get('/expense/step1', 'ExpenseController@getStep1')->name('postExpense')->middleware('guest');
Route::post('/expense/step1', 'ExpenseController@postStep1')->middleware('guest');
Route::get('/expense/step2', 'ExpenseController@getStep2')->middleware('guest');
Route::post('/expense/step2', 'ExpenseController@postStep2')->middleware('guest');
Route::get('/expense/done', 'ExpenseController@done')->middleware('guest');

Route::get('/expense/admin', 'ExpenseAdminController@index')->name('expense-admin');
Route::post('/expense/approve', 'ExpenseAdminController@approve');
Route::post('/expense/reject', 'ExpenseAdminController@reject');
Route::get('/expense/receipt/{expenseId}', 'ExpenseAdminController@receipt');
