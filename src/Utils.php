<?php

namespace Tebros\EmailConfirmation;

use Illuminate\Support\Facades\Route;

class Utils
{
    public static function routes(){
        $controller = 'Tebros\EmailConfirmation\Controllers\EMailConfirmationController';
        Route::get('confirm', $controller.'@showConfirmationForm')->name('confirm');
        Route::post('confirm', $controller.'@requestToken');
        Route::get('confirm/{token}', $controller.'@confirm');
    }
}
