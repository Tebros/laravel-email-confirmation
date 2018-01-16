<?php

namespace App\Http\Controllers;

use Tebros\EmailConfirmation\ConfirmsUsers;

class EMailConfirmationController extends Controller
{

    use ConfirmsUsers;

    /**
     * Where to redirect users after that.
     *
     * @var string
     */
    protected $redirectTo = '/login'; //TODO do i need this? for the middleware?

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming confirmation request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string|email|max:255|unique:users_confirmation',
        ]);
    }
}
