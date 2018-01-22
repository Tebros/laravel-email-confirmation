<?php

return [

    /*
    |--------------------------------------------------------------------------
    | EMailConfirmation Sprachzeilen
    |--------------------------------------------------------------------------
    |
    | Die folgenden Zeilen werden im Rahmen der E-Mail-Bestätigung verwendet.
    | Sie werden dem Benutzer teilweise als Statusnachricht auf der Webseite
    | oder als Text in der Bestätigungsemail angezeigt.
    |
    | Die Texte können je nach Anforderung beliebig angepasst werden.
    |
    */

    // Nachrichten in der Bestätigungsemail
    // Das Attribut :name kann hier überall verwendet werden
    'mail_greeting' => 'Hallo :name!',
    'mail_subject' => 'Bestätigung der E-Mail',
    'mail_introLines' => [
        'Du hast diese E-Mail erhalten, weil du dir einen Account auf unserer Webseite erstellt hast oder einen neuen Bestätigungslink angefordert hast.',
        'Damit du dich mit deinem Account einloggen kannst, musst du diese E-Mail bestätigen.',
    ],
    'mail_button_text' => 'Bestätige Account',
    'mail_outroLines' => [
        'Solltest du keinen Bestätigungslink angefordert haben, kannst du diese E-Mail ignorieren.',
    ],

    // ein User möchte sich anmelden, jedoch ist sein Account noch nicht bestätigt
    'account_not_confirmed' => 'Bitte bestätige deine E-Mail Adresse, damit du dich anmelden kannst!',

    // bei einer Registrierung wird eine bereits verwendete E-Mail angegeben
    'email_taken' => 'Diese E-Mail Adresse ist bereits vergeben!',

    // Registrierung abgeschlossen und Bestätigungsmail versendet
    'registered' => 'Registrierung erfolgreich abgeschlossen. Bitte prüfe deine E-Mails, um deinen Account zu bestätigen.',

    // button text um auf die Anmeldeseite zu gelangen
    'button_login' => 'Zum Login',

    // bei dem Versuch einen neuen Bestätigungslink anzufordern, wurde eine unbekannte E-Mail angegeben
    'email_unknown' => 'Es konnte kein Account zu dieser E-Mail gefunden werden!',

    // ein unerwarteter Fehler ist aufgetreten
    'unexpected_error' => 'Ein unerwarteter Fehler ist aufgetreten!',

    // ein neuer Bestätigungslink wurde angefordert und die E-Mail erfolgreich versendet
    'new_token_send' => 'Die E-Mail zur Bestätigung wurde erfolgreich versendet.',

    // jemand versucht einen Account mit einem ungültigen Link zu bestätigen
    'invalid_link' => 'Dieser Bestätigungslink ist ungültig!',

    // der Account wurde bestätigt, allerdings ist ein Fehler in der 'email_confirmation' Datenbank aufgetreten
    // der User sollte seinen bereits bestätigten Account noch einmal bestätigen. So kann der Fehler behoben werden
    'confirmed_with_error' => 'Dein Account wurde erfolgreich bestätigt. Jedoch ist ein Fehler aufgetreten! Bitte bestätige deshalb deinen Account erneut!',

    // der Account wurde erfolgreich bestätigt
    'confirmed' => 'Dein Account wurde erfolgreich bestätigt.',

];
