<?php

// Discussions...
Route::post('/discussions', 'DiscussionController@store');
Route::put('/discussions/{discussion}', 'DiscussionController@update');
Route::delete('/discussions/{discussion}', 'DiscussionController@delete');

// Groups...
Route::post('groups', 'GroupController@store');
Route::put('groups/{group}', 'GroupController@update');
Route::delete('groups/{group}', 'GroupController@delete');
