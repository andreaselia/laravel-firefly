<?php

Route::name(config('firefly.web.name'))->group(function() {
    Route::get('/', 'ForumController@index')->name('index');

    // Discussions...
<<<<<<< HEAD
    Route::prefix(config('firefly.discussions.prefix'))->group(function() {
=======
    Route::group(['prefix' => config('firefly.prefix.discussion')], function () {
>>>>>>> c71acf936fee5a4dcb7e8d00ef2caf2f68641fc9
        Route::get('{discussion}-{slug}', 'DiscussionController@show')->name('discussion.show')->where(['discussion' => '[0-9]+']);
        Route::put('{discussion}-{slug}/lock', 'DiscussionController@lock')->name('discussion.lock')->where(['discussion' => '[0-9]+']);
        Route::put('{discussion}-{slug}/unlock', 'DiscussionController@unlock')->name('discussion.unlock')->where(['discussion' => '[0-9]+']);
        Route::put('{discussion}-{slug}/pin', 'DiscussionController@pin')->name('discussion.pin')->where(['discussion' => '[0-9]+']);
        Route::put('{discussion}-{slug}/unpin', 'DiscussionController@unpin')->name('discussion.unpin')->where(['discussion' => '[0-9]+']);
<<<<<<< HEAD
        Route::get('{group}/discussion/create', 'DiscussionController@create')->name('discussion.create');
        Route::post('{group}/discussion', 'DiscussionController@store')->name('discussion.store');
        Route::put('{discussion}-{slug}', 'DiscussionController@update')->name('discussion.update')->where(['discussion' => '[0-9]+']);
        Route::get('{discussion}-{slug}/edit', 'DiscussionController@edit')->name('discussion.edit')->where(['discussion' => '[0-9]+']);
        Route::delete('{discussion}-{slug}', 'DiscussionController@delete')->name('discussion.delete')->where(['discussion' => '[0-9]+']);
=======
        Route::put('{discussion}-{slug}', 'DiscussionController@update')->name('discussion.update')->where(['discussion' => '[0-9]+']);
        Route::get('{discussion}-{slug}/edit', 'DiscussionController@edit')->name('discussion.edit')->where(['discussion' => '[0-9]+']);
        Route::delete('{discussion}-{slug}', 'DiscussionController@delete')->name('discussion.delete')->where(['discussion' => '[0-9]+']);

        Route::post('{discussion}-{slug}', 'PostController@store')->name('post.store');
        Route::put('{discussion}-{slug}/' . config('firefly.prefix.post') . '/{post}', 'PostController@update')->name('post.update');
        Route::delete('{discussion}-{slug}/' . config('firefly.prefix.post') . '/{post}', 'PostController@delete')->name('post.delete');
>>>>>>> c71acf936fee5a4dcb7e8d00ef2caf2f68641fc9
    });

    // Groups...
    Route::group(['prefix' => config('firefly.prefix.group')], function () {
        Route::get('{group}/' . config('firefly.prefix.discussion') . '/create', 'DiscussionController@create')->name('discussion.create');
        Route::post('{group}/' . config('firefly.prefix.discussion'), 'DiscussionController@store')->name('discussion.store');
        Route::get('/', 'GroupController@index')->name('group.index');
        Route::post('/', 'GroupController@store')->name('group.store');
        Route::get('create', 'GroupController@create')->name('group.create');
        Route::get('{group}/edit', 'GroupController@edit')->name('group.edit');
        Route::get('{group}', 'GroupController@show')->name('group.show');
        Route::put('{group}', 'GroupController@update')->name('group.update');
        Route::delete('{group}', 'GroupController@delete')->name('group.delete');
    });

    // Posts...
    Route::group(['prefix' => config('firefly.prefix.post')], function () {
        Route::get('{post}/edit', 'PostController@edit')->name('post.edit');
    });
});
