## Laravel E-Mail Confirmation ##

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Total Downloads][ico-downloads]][link-downloads]

This package integrates an email confirmation into the default laravel authentification.

It is has been developed and tested for Laravel 5.5 but it should also work with other versions of Laravel.

### Installation ###

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

```bash
php artisan migrate
```

### Configuration and Publishing ###

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

### Uninstallation ###

This is very simple. Just type the following command.

```bash
composer remove tebros/laravel-email-confirmation
```

After that you should remove the following two lines in your `routes/web.php` file.

```php
// Register routes for email confirmation. Die uri is "/confirm"
Tebros\EmailConfirmation\Utils::routes();
```