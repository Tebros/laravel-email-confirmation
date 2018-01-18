<?php

Route::get('confirm', 'Tebros\EmailConfirmation\Models\EMailConfirmationController@showConfirmationForm')->name('confirm');
Route::post('confirm', 'Tebros\EmailConfirmation\Models\EMailConfirmationController@requestToken');
Route::get('confirm/{token}', 'Tebros\EmailConfirmation\Models\EMailConfirmationController@confirm');