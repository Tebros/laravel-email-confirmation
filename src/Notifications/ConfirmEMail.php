<?php

namespace Tebros\EmailConfirmation\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;
use Tebros\EmailConfirmation\Models\EMailConfirmation;

class ConfirmEMail extends Notification
{
    use Queueable;

    /**
     * The user who needs a confirmation message
     *
     * @var EMailConfirmation
     */
    private $user;

    /**
     * Create a new notification instance.
     *
     * @param EMailConfirmation $user
     */
    public function __construct(EMailConfirmation $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $name = $this->user->name;

        $mail = new MailMessage;
        $mail   ->template(config('emailconfirmation.template'))
                ->level(config('emailconfirmation.level'))
                ->greeting(str_replace(':name', $name, trans('emailconfirmation::emailconfirmation.mail_greeting')))
                ->subject(str_replace(':name', $name, trans('emailconfirmation::emailconfirmation.mail_subject')));

        foreach(trans('emailconfirmation::emailconfirmation.mail_introLines') as $line){
            $mail->line(str_replace(':name', $name, $line));
        }

        $mail->action(str_replace(':name', $name, trans('emailconfirmation::emailconfirmation.mail_button_text')), url(config('app.url').route('confirm.attempt', $this->user->token, false)));

        foreach(trans('emailconfirmation::emailconfirmation.mail_outroLines') as $line){
            $mail->line(str_replace(':name', $name, $line));
        }

        return $mail;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
