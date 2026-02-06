<?php

namespace App\Listeners;

use App\Events\TurnEnded;
use App\Models\Asset;
use App\Models\ColonyAsset;
use Illuminate\Support\Facades\Session;

class ProgressResearch
{
    public function handle(TurnEnded $event): void
    {
        if ($event->game->chosenResearchId !== 0) {
            $xp = $event->game->scientists * config('game.base_work_per_turn');

            $asset = Asset::find($event->game->chosenResearchId);
            $researchInProgress = ColonyAsset::where([
                'colony_id' => $event->game->colony->id,
                'asset_id' => $event->game->chosenResearchId,
            ])->first();

            $newProgress = ($researchInProgress->xp ?? 0) + $xp;

            // Finish
            if ($newProgress >= $asset->xp) {
                $newProgress = $asset->xp;

                $event->game->chosenResearchId = 0;

                Session::push('messages', "Scientists finished researching $asset->name.");

                // TODO: AssetFinishedEvent
            } else {
                Session::push('messages', "Scientists researched $xp of $asset->name.");
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
