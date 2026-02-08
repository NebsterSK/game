<?php

namespace App\Listeners;

use App\Events\AssetFinished;
use App\Models\Asset;
use Illuminate\Support\Facades\Session;

class ListUnlockedAssets
{
    public function handle(AssetFinished $event): void
    {
        /** @var Asset[] $unlockedAssets */
        $unlockedAssets = Asset::where('parent_id', $event->asset->id)->orderBy('type')->get();

        foreach ($unlockedAssets as $asset) {
            Session::push('messages', $asset->type->toCrewType()->toUpperCase().' can now '.$asset->type->toVerb()." $asset->name.");
        }
    }
}
