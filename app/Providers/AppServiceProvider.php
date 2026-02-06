<?php

namespace App\Providers;

use App\Events\TurnEnded;
use App\Listeners\ProgressBuilding;
use App\Listeners\ProgressResearch;
use App\Listeners\ProgressTechnology;
use App\Listeners\UpdateColony;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        Event::listen(TurnEnded::class,UpdateColony::class);
        Event::listen(TurnEnded::class,ProgressBuilding::class);
        Event::listen(TurnEnded::class,ProgressTechnology::class);
        Event::listen(TurnEnded::class,ProgressResearch::class);
    }
}
