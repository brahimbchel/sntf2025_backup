<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpcomingConsultationNotification extends Notification
{
    use Queueable;

    public function __construct(public $consultationDate)
    {
        $this->consultationDate = $consultationDate;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
         return (new MailMessage)
            ->subject('Consultation Approaching')
            ->greeting("Hello {$notifiable->name},")
            ->line("You have a medical consultation scheduled on {$this->consultationDate->format('d M Y')}.")
            ->line('Please prepare accordingly.')
            ->salutation('– PFE Team');
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
