<?php

if (app()->environment('local')) {
    Route::get('/_testing/login/{id}', 'TestUserController@login');
}

Route::get('/{catchall?}', function () {
    return view('index');
})->where('catchall', '(.*)');
