<?php

namespace App\Notifications;

use App\Leave\LeaveRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RequestForCover extends Notification
{
    use Queueable;

    public $leave_request_info;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($leaveRequestInfo)
    {
        $this->leave_request_info = $leaveRequestInfo;
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
        return (new MailMessage)
                    ->subject('Request for cover')
                    ->markdown('mail.leave.request-for-cover', ['request' => $this->leave_request_info]);
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
