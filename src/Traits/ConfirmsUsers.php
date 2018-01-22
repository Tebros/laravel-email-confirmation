<?php

namespace Tebros\EmailConfirmation\Traits;

use App\Http\Controllers\Auth\RegisterController;
use App\User;
use Exception;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Tebros\EmailConfirmation\Models\EMailConfirmation;
use Tebros\EmailConfirmation\Notifications\ConfirmEMail;
use Tebros\EmailConfirmation\Utils;

trait ConfirmsUsers
{
    use RedirectsUsers;

    /**
     * Show the application confirmation form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showConfirmationForm()
    {
        return view('emailconfirmation::confirm');
    }

    /**
     * Handle a requestToken request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function requestToken(Request $request)
    {
        $this->validator($request->all())->validate();

        $this->sendToken($request);
        return back();
    }

    /**
     * Handle a confirmation request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $token
     * @return \Illuminate\Http\Response
     */
    public function confirm(Request $request, $token, RegisterController $registerController)
    {
        $user = $this->doConfirmation($request, $token);

        if(isset($user)){
            if(method_exists($registerController, 'confirmed')){
                $registerController->confirmed($request, $user);
            }else{
                throw new Exception(
                    'Method "confirmed" could not be found in class "'
                    .RegisterController::class.
                    '". Please make sure you replaced "use RegistersUsers;" with "use Tebros\EmailConfirmation\Traits\RegistersUsers;" !'
                );
            }
            return Utils::showStatusForm(trans('emailconfirmation::emailconfirmation.view_status_confirmed'), route('login'), trans('emailconfirmation::emailconfirmation.button_login'));
        }

        return $this->showConfirmationForm();
    }

    /**
     * Create, save and send the new token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    private function sendToken(Request $request)
    {
        //validate and get user
        $user = EMailConfirmation::where('email', $request->get('email'))->first();
        if(!isset($user)){
            $request->session()->flash('status_type', 'danger');
            $request->session()->flash('status', trans('emailconfirmation::emailconfirmation.email_unknown'));
            return false;
        }

        //create a new token and update database
        $user->token = Utils::generateToken($user->email);
        if(!$user->save()){
            $request->session()->flash('status_type', 'danger');
            $request->session()->flash('status', trans('emailconfirmation::emailconfirmation.unexpected_error'));
            return false;
        }

        //send Mail with new token
        $user->notify(new ConfirmEMail($user));

        $request->session()->flash('status_type', 'success');
        $request->session()->flash('status', trans('emailconfirmation::emailconfirmation.new_token_send'));
        return true;
    }

    /**
     * Move user into the users database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $token
     * @return User
     */
    private function doConfirmation(Request $request, $token)
    {
        //validate token
        if(empty($token)){
            $request->session()->flash('status_type', 'danger');
            $request->session()->flash('status', trans('emailconfirmation::emailconfirmation.invalid_link'));
            return null;
        }

        //get user by token
        $user = EMailConfirmation::where('token', $token)->first();
        if(!isset($user)){
            $request->session()->flash('status_type', 'danger');
            $request->session()->flash('status', trans('emailconfirmation::emailconfirmation.invalid_link'));
            return null;
        }

        //check if user already exists
        $tmp = User::where('email', $user->email)->first();
        if(isset($tmp)){
            $request->session()->flash('status_type', 'danger');
            $request->session()->flash('status', trans('emailconfirmation::emailconfirmation.unexpected_error'));
            return null;
        }

        //write user into database
        $newuser = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password
        ]);

        //remove user from database
        if(!$user->forceDelete()){
            $request->session()->flash('status_type', 'danger');
            $request->session()->flash('status', trans('emailconfirmation::emailconfirmation.confirmed_with_error'));
            return $newuser;
        }

        $request->session()->flash('status_type', 'success');
        $request->session()->flash('status', trans('emailconfirmation::emailconfirmation.confirmed'));
        return $newuser;
    }

}
