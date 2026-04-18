<?php

namespace App\Listeners;

use App\Events\StatutCandidatureMis;
use Illuminate\Support\Facades\Log;

class EnvoyerNotificationStatut
{
    public function handle(StatutCandidatureMis $event): void
    {
        $ancienStatut  = $event->ancienStatut;
        $nouveauStatut = $event->nouveauStatut;
        $date          = now()->format('d/m/Y H:i:s');

        Log::channel('candidatures')->info("[$date] Statut changé : $ancienStatut → $nouveauStatut");
    }
}