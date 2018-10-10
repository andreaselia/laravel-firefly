<?php

Route::name(config('firefly.web.name'))->group(function() {
    Route::get('/', 'ForumController@index')->name('forum.index');

    // Discussions...
    Route::get('{discussion}-{slug}', 'DiscussionController@show')->name('discussion.show');
    Route::put('{discussion}-{slug}/lock', 'DiscussionController@lock')->name('discussion.lock');
    Route::put('{discussion}-{slug}/unlock', 'DiscussionController@unlock')->name('discussion.unlock');
    Route::put('{discussion}-{slug}/stick', 'DiscussionController@stick')->name('discussion.stick');
    Route::put('{discussion}-{slug}/unstick', 'DiscussionController@unstick')->name('discussion.unstick');
    Route::get('{group}/discussion/create', 'DiscussionController@create')->name('discussion.create');
    Route::post('{group}/discussion', 'DiscussionController@store')->name('discussion.store');
    Route::put('{discussion}-{slug}', 'DiscussionController@update')->name('discussion.update');
    Route::delete('{discussion}-{slug}', 'DiscussionController@delete')->name('discussion.delete');
    Route::patch('discussions/{discussion}/hide', 'DiscussionController@hide')->name('discussion.hide');
    Route::patch('discussions/{discussion}/unhide', 'DiscussionController@unhide')->name('discussion.unhide');

    // Groups...
    Route::get('groups', 'GroupController@index')->name('group.index');
    Route::get('{group}', 'GroupController@show')->name('group.show');
    Route::post('groups', 'GroupController@store')->name('group.store');

    // Posts...
    Route::post('{discussion}-{slug}', 'PostController@store')->name('post.store');
    Route::put('{discussion}-{slug}/{post}', 'PostController@update')->name('post.update');
    Route::delete('{discussion}-{slug}/{post}', 'PostController@delete')->name('post.delete');
    Route::patch('posts/{post}/hide', 'PostController@hide')->name('post.hide');
    Route::patch('posts/{post}/unhide', 'PostController@unhide')->name('post.unhide');
});
