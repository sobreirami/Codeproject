<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'client', 'where' => ['id' => '[0-9]+']], function() {

    Route::get('', 'ClientController@index');
    Route::post('', 'ClientController@store');
    Route::get('{id}', 'ClientController@show');
    Route::delete('{id}', 'ClientController@destroy');
    Route::put('{id}', 'ClientController@update');

});

Route::group(['prefix' => 'project', 'where' => ['id' => '[0-9]+']], function() {

    Route::get('', 'ProjectController@index');
    Route::post('', 'ProjectController@store');
    Route::get('{id}', 'ProjectController@show');
    Route::delete('{id}', 'ProjectController@destroy');
    Route::put('{id}', 'ProjectController@update');

});