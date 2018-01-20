<?php

namespace Tebros\EmailConfirmation\Traits;

use Illuminate\Foundation\Auth\AuthenticatesUsers as LaravelAuthenticatesUsers;

trait AuthenticatesUsers
{
    use LaravelAuthenticatesUsers;

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
            'unique' => 'Please confirm your email adress to login!' //TODO translate
        ]);

        parent::validateLogin($request);
    }

}
