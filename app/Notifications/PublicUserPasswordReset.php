<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PublicUserPasswordReset extends Notification
{
    use Queueable;

    public $token;

    /**
     * Create a new notification instance.
     */
    public function __construct($token)
    {
        $this->token = $token;
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
        $url = url('/auth/reset-password/' . $this->token);

        return (new MailMessage)
            ->subject('Set Semula Kata Laluan - YB Dato\' Zunita Begum')
            ->greeting('Hai ' . $notifiable->name . ',')
            ->line('Anda menerima e-mel ini kerana kami menerima permintaan set semula kata laluan untuk akaun anda.')
            ->action('Set Semula Kata Laluan', $url)
            ->line('Pautan set semula kata laluan ini akan tamat tempoh dalam 24 jam.')
            ->line('Jika anda tidak meminta set semula kata laluan, tiada tindakan diperlukan.')
            ->salutation('Terima kasih,')
            ->salutation('Pasukan YB Dato\' Zunita Begum');
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
