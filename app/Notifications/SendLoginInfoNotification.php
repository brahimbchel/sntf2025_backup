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
            ->subject('Your Account Info')
            ->greeting("Hello " . $notifiable->prenom . ",")
            ->line('Your account has been created.')
            ->line("Email: {$this->email}")
            ->line("Temporary Password: {$this->password}")
            ->action('Login Now', route('filament.admin.auth.login'))
            ->line('Please change your password after first login!')
            ->salutation('– PFE Team');
    }
}
