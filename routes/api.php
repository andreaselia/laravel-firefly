<?php

// Discussions...
Route::group(['prefix' => config('firefly.prefix.discussion')], function () {
    Route::get('/', 'DiscussionController@index');
    Route::post('/', 'DiscussionController@store');
    Route::get('/{discussion}', 'DiscussionController@show');
    Route::put('/{discussion}', 'DiscussionController@update');
    Route::delete('/{discussion}', 'DiscussionController@delete');
    Route::put('{discussion}-{slug}/lock', 'DiscussionController@lock')->where(['discussion' => '[0-9]+']);
    Route::put('{discussion}-{slug}/unlock', 'DiscussionController@unlock')->where(['discussion' => '[0-9]+']);
    Route::put('{discussion}-{slug}/pin', 'DiscussionController@pin')->where(['discussion' => '[0-9]+']);
    Route::put('{discussion}-{slug}/unpin', 'DiscussionController@unpin')->where(['discussion' => '[0-9]+']);
    Route::post('{discussion}-{slug}/watch', 'DiscussionWatchController@store')->where(['discussion' => '[0-9]+']);
    Route::delete('{discussion}-{slug}/watch', 'DiscussionWatchController@delete')->where(['discussion' => '[0-9]+']);

    Route::post('{discussion}-{slug}', 'PostController@store');
    Route::put('{discussion}-{slug}/'.config('firefly.prefix.post').'/{post}', 'PostController@update');
    Route::delete('{discussion}-{slug}/'.config('firefly.prefix.post').'/{post}', 'PostController@delete');
});

// Groups...
Route::group(['prefix' => config('firefly.prefix.group')], function () {
    Route::get('/', 'GroupController@index');
    Route::post('/', 'GroupController@store');
    Route::get('{group}', 'GroupController@show');
    Route::put('{group}', 'GroupController@update');
    Route::delete('{group}', 'GroupController@delete');
});

// Posts...
Route::group(['prefix' => config('firefly.prefix.post')], function () {
    Route::post('{post}/correct', 'CorrectPostController@store');
    Route::delete('{post}/correct', 'CorrectPostController@delete');
});
