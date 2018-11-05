<?php

Route::name(config('firefly.web.name'))->group(function() {
    Route::get('/', 'ForumController@index')->name('index');

    // Discussions...
    Route::get('{discussion}-{slug}', 'DiscussionController@show')->name('discussion.show')->where(['discussion' => '[0-9]+']);
    Route::put('{discussion}-{slug}/lock', 'DiscussionController@lock')->name('discussion.lock')->where(['discussion' => '[0-9]+']);
    Route::put('{discussion}-{slug}/unlock', 'DiscussionController@unlock')->name('discussion.unlock')->where(['discussion' => '[0-9]+']);
    Route::put('{discussion}-{slug}/pin', 'DiscussionController@pin')->name('discussion.pin')->where(['discussion' => '[0-9]+']);
    Route::put('{discussion}-{slug}/unpin', 'DiscussionController@unpin')->name('discussion.unpin')->where(['discussion' => '[0-9]+']);
    Route::get('{group}/discussion/create', 'DiscussionController@create')->name('discussion.create');
    Route::post('{group}/discussion', 'DiscussionController@store')->name('discussion.store');
    Route::put('{discussion}-{slug}', 'DiscussionController@update')->name('discussion.update')->where(['discussion' => '[0-9]+']);
    Route::get('{discussion}-{slug}/edit', 'DiscussionController@edit')->name('discussion.edit')->where(['discussion' => '[0-9]+']);
    Route::delete('{discussion}-{slug}', 'DiscussionController@delete')->name('discussion.delete')->where(['discussion' => '[0-9]+']);

    // Groups...
    Route::get('groups', 'GroupController@index')->name('group.index');
    Route::get('{group}', 'GroupController@show')->name('group.show');
    Route::get('{group}/edit', 'GroupController@edit')->name('group.edit');
    Route::get('groups/create', 'GroupController@create')->name('group.create');
    Route::post('groups', 'GroupController@store')->name('group.store');
    Route::put('groups/{group}', 'GroupController@update')->name('group.update');
    Route::delete('groups/{group}', 'GroupController@delete')->name('group.delete');

    // Posts...
    Route::post('{discussion}-{slug}', 'PostController@store')->name('post.store');
    Route::put('{discussion}-{slug}/{post}', 'PostController@update')->name('post.update');
    Route::delete('{discussion}-{slug}/{post}', 'PostController@delete')->name('post.delete');
    Route::get('posts/{post}/edit', 'PostController@edit')->name('post.edit');
});
