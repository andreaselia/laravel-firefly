<?php

Route::get('/', 'ForumController@index');

// Tags...
Route::get('/{tag}', 'TagController@show');
