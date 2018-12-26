<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class RegisterNotify extends Notification
{
    use Queueable;
    protected $code;

    public function __construct($code)
    {
        $this->code = $code;
        //dd($this->code);
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('XX注册验证')//邮件主题
            ->line('感谢您注册XX商城，您的验证码为：'.$this->code);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
