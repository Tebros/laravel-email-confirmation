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
        if(doConfirmation($request, $token)){
            if(method_exists($registerController, 'confirmed')){
                $registerController->confirmed();
            }else{
                throw new Exception(
                    'Method "confirmed" could not be found in class "'
                    .RegisterController::class.
                    '". Please make sure you replaced "use RegistersUsers;" with "use Tebros\EmailConfirmation\Traits\RegistersUsers;" !'
                );
            }
            return Utils::showStatusForm('Account Confirmed', route('login'), 'Continue Login'); //TODO translate
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
            $request->session()->flash('status', 'Could not find a user for the given email!'); //TODO translate
            return false;
        }

        //create a new token and update database
        $user->token = Utils::generateToken($user->email);
        if(!$user->save()){
            $request->session()->flash('status_type', 'danger');
            $request->session()->flash('status', 'An unexpected error occurred!'); //TODO translate
            return false;
        }

        //send Mail with new token
        $user->notify(new ConfirmEMail($user));

        $request->session()->flash('status_type', 'success');
        $request->session()->flash('status', 'Confirmation E-Mail sent successfully.'); //TODO translate
        return true;
    }

    /**
     * Move user into the users database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $token
     * @return bool
     */
    private function doConfirmation(Request $request, $token)
    {

        //validate token
        if(empty($token)){
            $request->session()->flash('status_type', 'danger');
            $request->session()->flash('status', 'This is no valid link!'); //TODO translate
            return false;
        }

        //get user by token
        $user = EMailConfirmation::where('token', $token)->first();
        if(!isset($user)){
            $request->session()->flash('status_type', 'danger');
            $request->session()->flash('status', 'Could not find a user for the given token!'); //TODO translate
            return false;
        }

        //check if user already exists
        $tmp = User::where('email', $user->email)->first();
        if(isset($tmp)){
            $request->session()->flash('status_type', 'danger');
            $request->session()->flash('status', 'An unexpected error occurred! The user is already confirmed.'); //TODO translate
            return false;
        }

        //write user into database
        User::create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password
        ]);

        //remove user from database
        if(!$user->forceDelete()){
            $request->session()->flash('status_type', 'danger');
            $request->session()->flash('status', 'Your account has been confirmed but an unexpected error occurred! Please confirm your account a second time!'); //TODO translate
            return true;
        }

        $request->session()->flash('status_type', 'success');
        $request->session()->flash('status', 'Your account has been confirmed successfully.'); //TODO translate
        return true;
    }

}
