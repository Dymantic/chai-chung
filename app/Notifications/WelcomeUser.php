<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WelcomeUser extends Notification
{
    use Queueable;

    public $login;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($login)
    {
        $this->login = $login;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Access to company site')
            ->line("Hi " . $this->login['name'])
            ->line("An account has been created for you on the company website.")
            ->line("Your login email is: " . $this->login['email'])
            ->line("Your password is: " . $this->login['password'])
            ->line("Once you have logged in, please change your password to something only you know and remember")
            ->action('You may log in here', url('/admin'))
            ->line('Thank you!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
