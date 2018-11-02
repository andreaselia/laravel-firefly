<?php

// Discussions...
Route::post('/discussions', 'DiscussionController@store');
Route::put('/discussions/{discussion}', 'DiscussionController@update');
Route::delete('/discussions/{discussion}', 'DiscussionController@delete');

// Groups...
Route::post('groups', 'GroupController@store');
