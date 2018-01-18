<?php

namespace Tebros\EmailConfirmation\Traits;

use App\User;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tebros\EmailConfirmation\Models\UserConfirmation;

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
    public function confirm(Request $request, $token)
    {
        return $this->doConfirmation($request, $token)?$this->showSuccessForm():$this->showConfirmationForm();
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
        $user = UserConfirmation::where('email', $request->get('email'))->first();
        if(!isset($user)){
            $request->session()->flash('status_type', 'danger');
            $request->session()->flash('status', 'Could not find a user for the given email!'); //TODO translate
            return false;
        }

        //create a new token
        $token = $this->generateToken($user->email);

        //update database
        $user->token = $token;
        if(!$user->save()){
            $request->session()->flash('status_type', 'danger');
            $request->session()->flash('status', 'An unexpected error occurred!'); //TODO translate
            return false;
        }

        //TODO Send Mail with new token
        dd($token);

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
        $user = UserConfirmation::where('token', $token)->first();
        if(!isset($user)){
            $request->session()->flash('status_type', 'danger');
            $request->session()->flash('status', 'Could not find a user for the given token!'); //TODO translate
            return false;
        }

        //write User into database
        $newuser = User::create([
            'name' => $user->name,
            'email' => $user->email,
            'password' => $user->password
        ]);
        if(!$newuser->save()){
            $request->session()->flash('status_type', 'danger');
            $request->session()->flash('status', 'An unexpected error occurred!'); //TODO translate
            return false;
        }

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

    /**
     * Show the success message of the confirmation
     *
     * @return \Illuminate\Http\Response
     */
    private function showSuccessForm()
    {
        return view('emailconfirmation::success');
    }

    /**
     * Generate a unique token
     *
     * @param  mixed  $identifier
     * @return mixed
     */
    private function generateToken($identifier)
    {
        return str_slug(Hash::make($identifier).Hash::make(str_random(80)));
    }


}