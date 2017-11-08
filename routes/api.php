<?php

$api = app('Dingo\Api\Routing\Router');

$api->get('/github/callback', 'GithubController@callback');

$api->group(['prefix' => 'auth'], function($api) {

    $api->post('/login', 'AuthController@login');

    $api->post('/register', 'AuthController@register');
});


$api->group(['middleware' => 'api.auth'], function($api) {

    $api->group(['prefix' => 'auth'], function($api) {
        $api->get('/authenticate', 'AuthController@authenticate');

        $api->get('/logout', 'AuthController@logout');
    });

    $api->group(['prefix' => 'settings'], function($api) {
        $api->get('/options', 'SettingsController@getOptions');

        $api->get('/', 'SettingsController@getSettings');

        $api->get('/github/disconnect', 'GithubController@disconnect');

        $api->post('/', 'SettingsController@update');
    });

    $api->group(['prefix' => 'todo'], function($api) {
        $api->get('/', 'TodoController@list');

        $api->post('/', 'TodoController@create');

        $api->put('/{id}', 'TodoController@update');

        $api->get('/{id}', 'TodoController@view');
    });
});