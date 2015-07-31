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