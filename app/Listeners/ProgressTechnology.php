<?php

namespace App\Listeners;

use App\Events\TurnEnded;
use App\Models\Asset;
use App\Models\ColonyAsset;
use Illuminate\Support\Facades\Session;

class ProgressTechnology
{
    public function handle(TurnEnded $event): void
    {
        if ($event->game->chosenTechnologyId !== 0) {
            $xp = $event->game->engineers * config('game.base_work_per_turn');

            $asset = Asset::find($event->game->chosenTechnologyId);
            $technologyInProgress = ColonyAsset::where([
                'colony_id' => $event->game->colony->id,
                'asset_id' => $event->game->chosenTechnologyId,
            ])->first();

            $newProgress = ($technologyInProgress->xp ?? 0) + $xp;

            // Finish
            if ($newProgress >= $asset->xp) {
                $newProgress = $asset->xp;

                $event->game->chosenTechnologyId = 0;

                Session::push('messages', "Engineers finished developing $asset->name.");

                // TODO: AssetFinishedEvent
            } else {
                Session::push('messages', "Engineers developed $xp of $asset->name.");
            }

            ColonyAsset::upsert([
                'xp' => $newProgress,
                'colony_id' => $event->game->colony->id,
                'asset_id' => $asset->id,
            ], [
                'colony_id',
                'asset_id',
            ], [
                'xp',
            ]);
        }
    }
}
