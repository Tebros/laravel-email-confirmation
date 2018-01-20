<?php

namespace Tebros\EmailConfirmation;

use Illuminate\Support\Facades\Route;

class Utils
{
    /**
     * Register all needed routes for email confirmation
     */
    public static function routes(){
        $controller = '\Tebros\EmailConfirmation\Controllers\EMailConfirmationController';
        Route::get('confirm', $controller.'@showConfirmationForm')->name('confirm');
        Route::post('confirm', $controller.'@requestToken')->name('confirm.request');
        Route::get('confirm/{token}', $controller.'@confirm')->name('confirm.attempt');
    }

    /**
     * Show a view with custom title, formaction and buttontext.
     * The view contains the status message of the session.
     *
     * @param mixed  $title
     * @param mixed  $action
     * @param mixed  $buttontext
     * @return \Illuminate\Http\Response
     */
    public static function showStatusForm($title, $action, $buttontext)
    {
        return view('emailconfirmation::status')->with([
            'title' => $title,
            'action' => $action,
            'buttontext' => $buttontext,
        ]);
    }

    /**
     * Generate a unique and url friendly token
     *
     * Just the first 20 characters of the identifier are used
     *
     * @param $identifier
     * @param int $length
     * @return string
     */
    public static function generateToken($identifier, $length = 80)
    {
        return str_slug(bcrypt(substr($identifier, 0, 20)).bcrypt(str_random($length)));
    }
}
