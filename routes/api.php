<?php

// Discussions...
Route::post('/discussions', 'DiscussionController@store');
Route::put('/discussions/{discussion}', 'DiscussionController@update');
Route::delete('/discussions/{discussion}', 'DiscussionController@delete');
Route::put('{discussion}-{slug}/lock', 'DiscussionController@lock')->where(['discussion' => '[0-9]+']);
Route::put('{discussion}-{slug}/unlock', 'DiscussionController@unlock')->where(['discussion' => '[0-9]+']);
Route::put('{discussion}-{slug}/stick', 'DiscussionController@stick')->where(['discussion' => '[0-9]+']);
Route::put('{discussion}-{slug}/unstick', 'DiscussionController@unstick')->where(['discussion' => '[0-9]+']);

// Groups...
Route::post('groups', 'GroupController@store');
Route::put('groups/{group}', 'GroupController@update');
Route::delete('groups/{group}', 'GroupController@delete');

// Posts...
Route::post('{discussion}-{slug}', 'PostController@store');
Route::put('{discussion}-{slug}/{post}', 'PostController@update');
Route::delete('{discussion}-{slug}/{post}', 'PostController@delete');
