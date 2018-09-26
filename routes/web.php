<?php

Route::get('/', 'ForumController@index')->name('forum.index');

// Groups...
Route::get('{tag}', 'GroupController@show')->name('group.show');

// Discussions...
Route::get('{discussion}-{slug}', 'DiscussionController@show')->name('discussion.show');
Route::get('{tag}/discussion/create', 'DiscussionController@create')->name('discussion.create');
Route::post('{tag}/discussion', 'DiscussionController@store')->name('discussion.store');
Route::put('{discussion}-{slug}', 'DiscussionController@update')->name('discussion.update');
Route::delete('{discussion}-{slug}', 'DiscussionController@delete')->name('discussion.delete');
