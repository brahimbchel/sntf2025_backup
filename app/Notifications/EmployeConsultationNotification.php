<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmployeConsultationNotification extends Notification
{
    protected $medecinName;
    protected $date;

    public function __construct($medecinName, $date)
    {
        $this->medecinName = $medecinName;
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
            ->subject('Consultation programmée')
            ->greeting("Bonjour {$notifiable->prenom},")
            ->line("Une consultation avec le Dr. {$this->medecinName} a été programmée.")
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
