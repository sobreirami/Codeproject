<?php

Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

Route::group(['middleware' => 'oauth'], function() {

    Route::group(['prefix' => 'client', 'where' => ['id' => '[0-9]+', 'id_user' => '[0-9]+']], function() {

        Route::get('', 'ClientController@index');
        Route::post('', 'ClientController@store');
        Route::get('{id}', 'ClientController@show');
        Route::delete('{id}', 'ClientController@destroy');
        Route::put('{id}', 'ClientController@update');

    });

    Route::group(['prefix' => 'project', 'where' => ['id' => '[0-9]+', 'id_user' => '[0-9]+']], function() {

        Route::get('', 'ProjectController@index');
        Route::post('', 'ProjectController@store');
        Route::get('{id}', 'ProjectController@show');
        Route::delete('{id}', 'ProjectController@destroy');
        Route::put('{id}', 'ProjectController@update');

        Route::get('{id}/members', 'ProjectController@Member');
        Route::post('{id}/members', 'ProjectController@addMember');
        Route::delete('{id}/members/{id_user}', 'ProjectController@removeMember');
        Route::get('{id}/members/{id_user}', 'ProjectController@isMember');

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

        Route::group(['prefix' => 'member', 'where' => ['id' => '[0-9]+']], function() {
            Route::get('', 'ProjectMemberController@index');
            Route::post('', 'ProjectMemberController@store');
            Route::get('{id}', 'ProjectMemberController@show');
            Route::delete('{id}', 'ProjectMemberController@destroy');
            Route::put('{id}', 'ProjectMemberController@update');
        });

    });

});