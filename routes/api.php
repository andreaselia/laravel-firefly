<?php

Route::post('/discussions', 'DiscussionController@store');
Route::put('/discussions/{discussion}', 'DiscussionController@update');
Route::delete('/discussions/{discussion}', 'DiscussionController@delete');
