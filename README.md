Laravel E-Mail Confirmation
===========================

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

This package integrates an email confirmation into the default laravel authentification.

It is has been developed and tested for Laravel 5.5 but it should also work with other versions of Laravel.

Installation
-------------

Make use of composer to require this package. 

The installation appends a function call in the `routes/web.php` file automatically. 
Please do **not** comment it out!

```bash
composer require tebros/laravel-email-confirmation
```

Run the `make:auth` command if not already done.

Skip this step if you have already executed the command in the past.

```bash
php artisan make:auth
```

Make a migration to create the needed table `users_confirmation`.

```bashneed to
php artisan migrate
```

Edit the `app/Http/Controllers/Auth/RegisterController.php` file.

The editing is quite simple. 
To hook into the default Laravel authentification prozess, you need to change the `RegistersUsers` trait at the top.

```php
//comment out the line like this or just override it
//use RegistersUsers;

use \Tebros\EmailConfirmation\Traits\RegistersUsers; //use this trait instead of the default
``` 

Edit the `app/Http/Controllers/Auth/LoginController.php` file.

It is required to display correct a message if the account is not confirmed.

```php
//comment out the line like this or just override it
//use AuthenticatesUsers;

use \Tebros\EmailConfirmation\Traits\AuthenticatesUsers; //use this trait instead of the default
``` 

Make sure your `config/mail.php` file contains these important settings:
- MAIL_DRIVER
- MAIL_HOST
- MAIL_PORT
- MAIL_USERNAME, MAIL_PASSWORD
- MAIL_FROM_ADDRESS, MAIL_FROM_NAME

Moreover, make sure your `config/app.php` file contains these important settings:
- APP_NAME
- APP_URL

Configuration and Publishing
-----------------------------

After the installation you can make use of the `confirm` route name to link the `Resend Confirmation E-Mail` site.

**Important!** You should edit your `auth/login.blade.php` view and add this link to request a new confirmation email!

```php
<div class="form-group">
    <div class="col-md-8 col-md-offset-4">
        <button type="submit" class="btn btn-primary">
            Login
        </button>

        <a class="btn btn-link" href="{{ route('password.request') }}">
            Forgot Your Password?
        </a>

        <a class="btn btn-link" href="{{ route('confirm') }}">
            Resend Confirmation Link?
        </a>
    </div>
</div>
```

If you want to configure the email confirmation, run the following command.

You can modify the `config/emailconfirmation.php` file as you wish.

```bash
php artisan vendor:publish --tag=emailconfirmation-config
```

To change a message or text you can modify the files in the `lang/vendor/emailconfirmation` directory.

Run the following command to do this.

```bash
php artisan vendor:publish --tag=emailconfirmation-translation
```

If you do not want to use the default Laravel views, you can modify the views in the `views/vendor/emailconfirmation` directory.

Run the following command to do this.

```bash
php artisan vendor:publish --tag=emailconfirmation-views
```

Uninstallation
--------------

You should remove the following two lines in your `routes/web.php` file.

```php
// Register routes for email confirmation. The uri is "/confirm"
Tebros\EmailConfirmation\Utils::routes();
```

Edit the `app/Http/Controllers/Auth/RegisterController.php` file and 
the `app/Http/Controllers/Auth/LoginController.php` file to remove the Laravel hook.

```php
//remove the comment that the orifinal trait is used
use RegistersUsers;

//remove the whole line or comment it out
//use \Tebros\EmailConfirmation\Traits\RegistersUsers; 
``` 

```php
//remove the comment that the orifinal trait is used
use AuthenticatesUsers;

//remove the whole line or comment it out
//use \Tebros\EmailConfirmation\Traits\AuthenticatesUsers; 
``` 

Now just type the following command.

```bash
composer remove tebros/laravel-email-confirmation
```

License
-------

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

[ico-version]: https://img.shields.io/packagist/v/tebros/laravel-email-confirmation.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/tebros/laravel-email-confirmation.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/tebros/laravel-email-confirmation
[link-downloads]: https://packagist.org/packages/tebros/laravel-email-confirmation
