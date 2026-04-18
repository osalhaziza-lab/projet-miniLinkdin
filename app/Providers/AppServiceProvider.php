<?php

namespace App\Providers;

use App\Events\CandidatureDeposee;
use App\Events\StatutCandidatureMis;
use App\Listeners\EnvoyerNotificationCandidature;
use App\Listeners\EnvoyerNotificationStatut;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::listen(
            CandidatureDeposee::class,
            EnvoyerNotificationCandidature::class,
        );

        Event::listen(
            StatutCandidatureMis::class,
            EnvoyerNotificationStatut::class,
        );
    }
}