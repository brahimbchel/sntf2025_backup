<?php

namespace App\Console\Commands;

use App\Models\Consultation;
use App\Notifications\ConsultationReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SendConsultationReminders extends Command
{
    protected $signature = 'consultations:send-reminders';
    protected $description = 'Send reminder emails before consultation dates';

    public function handle()
    {
        $tomorrow = now()->addDay()->toDateString();

        $consultations = Consultation::whereDate('date_consultation', $tomorrow)->get();

        foreach ($consultations as $consultation) {
            $user = $consultation->user; // or patient, doctor, etc.
            if ($user) {
                $user->notify(new ConsultationReminderNotification($consultation));
            }
        }

        $this->info('Consultation reminders sent.');
    }
}
