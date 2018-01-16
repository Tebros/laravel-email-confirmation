<?php

Route::get('confirm', 'EMailConfirmationController@showConfirmationForm')->name('confirm');
Route::post('confirm', 'EMailConfirmationController@requestToken');
Route::get('confirm/{token}', 'EMailConfirmationController@confirm');