<?php

namespace App\Listeners;

use App\Events\TurnEnded;
use App\Models\Asset;
use App\Models\ColonyAsset;
use Illuminate\Support\Facades\Session;

class ProgressBuilding
{
    public function handle(TurnEnded $event): void
    {
        if ($event->game->chosenBuildingId !== 0) {
            $xp = $event->game->builders * config('game.base_work_per_turn');

            $asset = Asset::find($event->game->chosenBuildingId);
            $buildingInProgress = ColonyAsset::where([
                'colony_id' => $event->game->colony->id,
                'asset_id' => $event->game->chosenBuildingId,
            ])->first();

            $newProgress = ($buildingInProgress->xp ?? 0) + $xp;

            // Finish
            if ($newProgress >= $asset->xp) {
                $newProgress = $asset->xp;

                $event->game->chosenBuildingId = 0;

                Session::push('messages', "Builders finished building $asset->name.");

                // TODO: AssetFinishedEvent
            } else {
                Session::push('messages', "Builders built $xp of $asset->name.");
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
