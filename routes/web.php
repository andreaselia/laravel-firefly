<?php

Route::get('/', 'ForumController@index')->name('forum.index');

// Groups...
Route::get('{tag}', 'GroupController@show')->name('group.show');

// Discussions...
Route::get('{discussion}-{slug}', 'DiscussionController@show')->name('discussion.show');
Route::put('{discussion}-{slug}/lock', 'DiscussionController@lock')->name('discussion.lock');
Route::put('{discussion}-{slug}/unlock', 'DiscussionController@unlock')->name('discussion.unlock');
Route::put('{discussion}-{slug}/stick', 'DiscussionController@stick')->name('discussion.stick');
Route::put('{discussion}-{slug}/unstick', 'DiscussionController@unstick')->name('discussion.unstick');
Route::get('{tag}/discussion/create', 'DiscussionController@create')->name('discussion.create');
Route::post('{tag}/discussion', 'DiscussionController@store')->name('discussion.store');
Route::put('{discussion}-{slug}', 'DiscussionController@update')->name('discussion.update');
Route::delete('{discussion}-{slug}', 'DiscussionController@delete')->name('discussion.delete');

// Posts...
Route::post('{discussion}-{slug}', 'PostController@store')->name('post.store');
