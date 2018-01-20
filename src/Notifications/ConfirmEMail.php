<?php

namespace Tebros\EmailConfirmation\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
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
        //TODO add custom template support
        //TODO translate
        return (new MailMessage)
                    ->greeting('Hello '.$this->user->name.'!')
                    ->subject('Confirm E-Mail')
                    ->line('You are receiving this email because your account, based on this email adress, needs a confirmation.')
                    ->action('Confirm Account', url(config('app.url').route('confirm.attempt', $this->user->token)))
                    ->line('If you did not request a confirmation link, no further action is required.');
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
