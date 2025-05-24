<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConsultationDeletedNotification extends Notification
{
    protected $consultation;

    public function __construct($consultation)
    {
        $this->consultation = $consultation;
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
        $date = optional($this->consultation->date_consultation)?->format('d/m/Y') ?? 'date inconnue';

       return (new MailMessage)
            ->subject('Annulation de consultation')
            ->line('Votre consultation prévue le ' . $date . ' a été annulée.')
            ->line('Médecin: ' . $this->consultation->medecin->nom . ' ' . $this->consultation->medecin->prenom)
            ->line('Type: ' . $this->consultation->type)
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
