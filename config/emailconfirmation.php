<?php

return [

    /*
    |--------------------------------------------------------------------------
    | E-Mail Template
    |--------------------------------------------------------------------------
    |
    | Here you can set the template to render for the confirmation email.
    |
    | You can use the following variables in your *.blade.php file:
    | $greeting, $level, $introLines, $actionText, $actionUrl,
    | $outroLines, $salutation
    |
    */

    'template' => 'notifications::email',

    /*
    |--------------------------------------------------------------------------
    | E-Mail Level
    |--------------------------------------------------------------------------
    |
    | Here you can set the level of the confirmation email.
    |
    | success (by default this level has a green button)
    | error   (by default this level has a red button)
    | default (by default this level has a blue button)
    |
    */

    'level' => 'default',

];
