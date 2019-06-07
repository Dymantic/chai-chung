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
            ->subject('歡迎來到嘉眾會計師事務所')
            ->line($this->login['name'] . "您好")
            ->line("公司已註冊了您的帳戶。")
            ->line("您的使用者名稱: " . $this->login['email'])
            ->line("您的密碼: " . $this->login['password'])
            ->line("登入系統後請立即更新您的密碼")
            ->action('登入', url('/admin'))
            ->line('謝謝！');
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
