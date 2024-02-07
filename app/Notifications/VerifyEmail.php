<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use App\Models\VerificationCode;
use Illuminate\Support\HtmlString;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class VerifyEmail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public $id,public $name)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $otpCode = rand(123456, 999999);
        VerificationCode::create([
            'user_id' => $this->id,
            'otp' => $otpCode,
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);
        return (new MailMessage)
            ->subject('Verify Email Address')
            ->greeting('Hello '.$this->name.' !')
            ->line('Please use the following OTP to verify your email address:')
            ->line(new HtmlString('<strong>' . $otpCode . '</strong>'))
            ->line('If you did not create an account, no further action is required.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
