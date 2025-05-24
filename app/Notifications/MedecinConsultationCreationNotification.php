<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MedecinConsultationCreationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $patientName;
    protected $date_consultation;

    public function __construct(string $patientName, string $date_consultation)
    {
        $this->patientName = $patientName;
        $this->date_consultation = $date_consultation;
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


    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouvelle consultation programmée')
            ->greeting("Bonjour  {$notifiable->prenom},")
            ->line("Une nouvelle consultation a été programmée.")
            ->line("Patient : {$this->patientName}")
            ->line("Date : {$this->date_consultation}")
            ->action('Voir la consultation', url('/consultations')) // replace with actual route if needed
            ->salutation('– Équipe PFE');
    }
}
