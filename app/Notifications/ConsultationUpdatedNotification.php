<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConsultationUpdatedNotification extends Notification
{
    protected $consultation;
    protected $oldDate;
    protected $newDate;

    public function __construct($consultation, $oldDate, $newDate)
    {
        $this->consultation = $consultation;
        $this->oldDate = $oldDate;
        $this->newDate = $newDate;
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
        $oldDateFormatted = $this->oldDate?->format('d/m/Y') ?? 'date inconnue';
        $newDateFormatted = $this->newDate?->format('d/m/Y') ?? 'date inconnue';

        return (new MailMessage)
            ->subject('Modification de la date de consultation')
            ->line('La date de votre consultation a été modifiée.')
            ->line('Ancienne date: ' . $oldDateFormatted)
            ->line('Nouvelle date: ' . $newDateFormatted)
            ->line('Si vous avez des questions, veuillez contacter votre administrateur.')
            ->salutation('Cordialement');
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
