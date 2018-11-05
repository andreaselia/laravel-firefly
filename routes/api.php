<?php

// Discussions...
Route::group(['prefix' => config('firefly.prefix.discussion')], function () {
    Route::post('/', 'DiscussionController@store');
    Route::put('/{discussion}', 'DiscussionController@update');
    Route::delete('/{discussion}', 'DiscussionController@delete');
    Route::put('{discussion}-{slug}/lock', 'DiscussionController@lock')->where(['discussion' => '[0-9]+']);
    Route::put('{discussion}-{slug}/unlock', 'DiscussionController@unlock')->where(['discussion' => '[0-9]+']);
    Route::put('{discussion}-{slug}/pin', 'DiscussionController@pin')->where(['discussion' => '[0-9]+']);
    Route::put('{discussion}-{slug}/unpin', 'DiscussionController@unpin')->where(['discussion' => '[0-9]+']);

    Route::post('{discussion}-{slug}', 'PostController@store');
    Route::put('{discussion}-{slug}/' . config('firefly.prefix.post') . '/{post}', 'PostController@update');
    Route::delete('{discussion}-{slug}/' . config('firefly.prefix.post') . '/{post}', 'PostController@delete');
});

// Groups...
Route::group(['prefix' => config('firefly.prefix.group')], function () {
    Route::post('/', 'GroupController@store');
    Route::put('{group}', 'GroupController@update');
    Route::delete('{group}', 'GroupController@delete');
});

// Posts...
