<?php

Route::group(
    [
        'prefix'=>'im',
        'namespace' => 'CreateSites\IMVK\Controllers',
        'middleware' => ['web', 'auth']
    ],

    function()
    {

        Route::get('/', [
            'uses' => 'IMVKController@index',
            'as' => 'messages.all',
        ]);

        Route::get('/{from_user_id}', [
            'uses' => 'IMVKController@messages',
            'as' => 'messages.show',
        ]);

    }
);

Route::group(
    [
        'prefix'=>'api/im',
        'namespace' => 'CreateSites\IMVK\Controllers\Api',
        'middleware' => ['web', 'auth']
    ],

    function()
    {

        Route::get('/', [
            'uses' => 'ApiIMVKController@index',
        ]);

        Route::get('/{from_user_id}', [
            'uses' => 'ApiIMVKController@show',
        ]);

        Route::post('/', [
            'uses' => 'ApiIMVKController@sendMessage',
        ]);

    }
);