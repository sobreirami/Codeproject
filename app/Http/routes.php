<?php

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

    Route::group(['prefix' => 'note', 'where' => ['id' => '[0-9]+']], function() {
        Route::get('', 'ProjectNoteController@index');
        Route::post('', 'ProjectNoteController@store');
        Route::get('{id}', 'ProjectNoteController@show');
        Route::delete('{id}', 'ProjectNoteController@destroy');
        Route::put('{id}', 'ProjectNoteController@update');
    });

    Route::group(['prefix' => 'task', 'where' => ['id' => '[0-9]+']], function() {
        Route::get('', 'ProjectTaskController@index');
        Route::post('', 'ProjectTaskController@store');
        Route::get('{id}', 'ProjectTaskController@show');
        Route::delete('{id}', 'ProjectTaskController@destroy');
        Route::put('{id}', 'ProjectTaskController@update');
    });

});