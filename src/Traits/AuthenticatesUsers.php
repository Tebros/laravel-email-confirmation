<?php

namespace Tebros\EmailConfirmation\Traits;

use Illuminate\Foundation\Auth\AuthenticatesUsers as LaravelAuthenticatesUsers;
use Illuminate\Http\Request;

trait AuthenticatesUsers
{
    use LaravelAuthenticatesUsers {
        validateLogin as protected laravelValidateLogin;
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            'email' => 'unique:email_confirmation,email'
        ], [
            'unique' => trans('emailconfirmation::emailconfirmation.account_not_confirmed')
        ]);

        $this->laravelValidateLogin($request);
    }

}
