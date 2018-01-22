<?php

return [

    /*
    |--------------------------------------------------------------------------
    | EMailConfirmation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during email confirmation for
    | various messages that we need to display to the user. You are free to
    | modify these language lines according to your application's requirements.
    |
    */

    // text in the 'Resend Confirmation E-Mail' view
    'view_request_title' => 'Resend Confirmation E-Mail',
    'view_request_email' => 'E-Mail Address',
    'view_request_submit' => 'Send Confirmation Link',

    // titles of the status message view
    'view_status_registered' => 'Registered',
    'view_status_confirmed' => 'Account Confirmed',

    // messages for the confirmation email
    // you can use the attribute :name everywhere you like
    'mail_greeting' => 'Hello :name!',
    'mail_subject' => 'Confirm E-Mail',
    'mail_introLines' => [
        'You are receiving this email because your account, based on this email adress, needs a confirmation.',
    ],
    'mail_button_text' => 'Confirm Account',
    'mail_outroLines' => [
        'If you did not request a confirmation link, no further action is required.',
    ],

    // a user wants to login but the account is not confirmed
    'account_not_confirmed' => 'Please confirm your email adress to login!',

    // someone wants to register but the email has already been taken
    'email_taken' => 'The :attribute has already been taken.',

    // registration finished and confirmation mail sended
    'registered' => 'Confirmation E-Mail sent successfully. Please check your mails.',

    // button text to go to the login page
    'button_login' => 'Continue Login',

    // request a new confirmation token but email does not exists
    'email_unknown' => 'Could not find a user for the given email!',

    // an unexpected error occurred
    'unexpected_error' => 'An unexpected error occurred!',

    // a new confirmation token was requested and the mail was send successfully
    'new_token_send' => 'Confirmation E-Mail sent successfully.',

    // someone wants to confirm an account with an invalid token
    'invalid_link' => 'This is an invalid link!',

    // the account is confirmed but there went something wrong in the 'email_confirmation' database
    'confirmed_with_error' => 'Your account has been confirmed but an unexpected error occurred! Please confirm your account a second time!',

    // the account is now confirmed
    'confirmed' => 'Your account has been confirmed successfully.',

];
