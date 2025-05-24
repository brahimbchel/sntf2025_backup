<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MedecinConsultationNotification extends Notification
{
    protected $patientName;
    protected $date;

    public function __construct($patientName, $date)
    {
        $this->patientName = $patientName;
        $this->date = $date;
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
        return (new MailMessage)
            ->subject('Nouvelle consultation programmée')
            ->greeting("Bonjour Dr. {$notifiable->prenom},")
            ->line("Une nouvelle consultation a été programmée avec le patient {$this->patientName}.")
            ->line("Date : {$this->date}")
            ->action('Voir les détails', url('/consultations'))
            ->salutation('– Équipe PFE');

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
