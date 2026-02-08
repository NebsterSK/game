<?php

namespace App\Listeners;

use App\Events\TurnEnded;
use Illuminate\Support\Facades\Session;

class UpdateColony
{
    public function handle(TurnEnded $event): void
    {
        Session::remove('messages');

        $event->game->colony->update([
            'turn' => $event->game->colony->turn + 1,
            'population' => $event->game->population,
            'builders' => $event->game->builders,
            'engineers' => $event->game->engineers,
            'scientists' => $event->game->scientists,
        ]);

        if ($event->game->colony->population > 0) {
            Session::push('messages', 'We have available population ('.$event->game->colony->population.') that is not assigned to any role.');
        }
    }
}
