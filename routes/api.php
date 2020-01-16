<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'API', 'as' => 'api::'], function () {
    Route::group(['prefix' => 'patient', 'as' => 'patient::'], function () {
        Route::get('/answer', 'PatientController@getAnswers')->name('answer');
    });
    Route::group(['prefix' => 'answer', 'as' => 'answer::'], function () {
        Route::post('/', 'AnswerController@create')->name('create');
        Route::put('/', 'AnswerController@update')->name('update');
    });
});
