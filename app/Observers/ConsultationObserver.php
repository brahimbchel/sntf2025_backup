<?php

namespace App\Observers;

use App\Models\Consultation;
use Filament\Notifications\Notification;
use App\Notifications\ConsultationCreatedNotification;

class ConsultationObserver
{
    /**
     * Handle the Consultation "created" event.
     */
    public function created(Consultation $consultation)
    {
        // Send a notification to the user/medecin/whatever
        $user = $consultation->dossierMedical->employe; // just example
        Notification::send($user, new ConsultationCreatedNotification($consultation));
    }
    /**
     * Handle the Consultation "updated" event.
     */
    public function updated(Consultation $consultation): void
    {
        //
    }

    /**
     * Handle the Consultation "deleted" event.
     */
    public function deleted(Consultation $consultation): void
    {
        //
    }

    /**
     * Handle the Consultation "restored" event.
     */
    public function restored(Consultation $consultation): void
    {
        //
    }

    /**
     * Handle the Consultation "force deleted" event.
     */
    public function forceDeleted(Consultation $consultation): void
    {
        //
    }
}
