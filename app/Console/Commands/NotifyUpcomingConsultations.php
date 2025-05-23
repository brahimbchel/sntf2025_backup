<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Consultation;
use App\Notifications\UpcomingConsultationNotification;
use Carbon\Carbon;

// in comand line run: php artisan notify:consultations
class NotifyUpcomingConsultations extends Command
{
    protected $signature = 'notify:consultations';
    protected $description = 'Notify employes about upcoming consultations in 2 days';

    public function handle()
    {
        $targetDate = Carbon::now()->addDays(2)->startOfDay();

        $consultations = Consultation::with('dossier_medical.employe')
            ->whereDate('date_consultation', $targetDate)
            ->get();

        
        foreach ($consultations as $consultation) {
            $dossier = $consultation->dossier_medical;

            if ($dossier && $dossier->employe && $dossier->employe->email) {
                $employe = $dossier->employe;
                $employe->notify(new UpcomingConsultationNotification($consultation->date_consultation));
            }
        }

        $this->info("Notifications sent for consultations on {$targetDate->format('Y-m-d')}");
    }
}
