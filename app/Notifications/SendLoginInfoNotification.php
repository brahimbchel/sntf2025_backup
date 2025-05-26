<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendLoginInfoNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $email;
    protected $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
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
            ->subject('Informations de votre compte')
            ->greeting("Bonjour " . $notifiable->prenom . ",")
            ->line('Votre compte a été créé.')
            ->line("Email : {$this->email}")
            ->line("Mot de passe temporaire : {$this->password}")
            ->action('Se connecter maintenant', route('filament.admin.auth.login'))
            ->line('Veuillez changer votre mot de passe après votre première connexion !')
            ->salutation('– Équipe PFE');
    }
}
