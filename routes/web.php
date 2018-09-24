<?php

Route::get('/', 'ForumController@index');

// Groups...
Route::get('{tag}', 'GroupController@show')->name('group.show');

// Discussions...
Route::get('{id}-{slug}', 'DiscussionController@show')->name('discussion.show');
Route::get('{tag}/discussion/create', 'DiscussionController@create')->name('discussion.create');
Route::post('{tag}/discussion', 'DiscussionController@store')->name('discussion.store');
Route::put('{id}-{slug}', 'DiscussionController@update')->name('discussion.update');
Route::delete('{id}-{slug}', 'DiscussionController@delete')->name('discussion.delete');
