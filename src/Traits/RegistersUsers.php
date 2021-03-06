<?php

namespace Tebros\EmailConfirmation\Traits;

use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers as LaravelRegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tebros\EmailConfirmation\Models\EMailConfirmation;
use Tebros\EmailConfirmation\Notifications\ConfirmEMail;
use Tebros\EmailConfirmation\Utils;

trait RegistersUsers
{
    use LaravelRegistersUsers;

    /**
     * This was the old "register" function.
     *
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function confirmed(Request $request, User $user)
    {
        event(new Registered($user));

        $this->registered($request, $user);
    }

    /**
     * Handle a registration request for the application.
     *
     * Send a confirmation email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $data = $request->all();

        $this->validator($data)->validate();

        Validator::make($data, [
            'email' => 'unique:email_confirmation,email'
        ], [
            'unique' => trans('emailconfirmation::emailconfirmation.email_taken')
        ])->validate();

        $user = EMailConfirmation::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'token' => Utils::generateToken($data['email'])
        ]);

        //send mail with new token
        $user->notify(new ConfirmEMail($user));

        $request->session()->flash('status_type', 'success');
        $request->session()->flash('status', trans('emailconfirmation::emailconfirmation.registered'));

        return Utils::showStatusForm(trans('emailconfirmation::emailconfirmation.view_status_registered'), route('login'), trans('emailconfirmation::emailconfirmation.button_login'));
    }

}
