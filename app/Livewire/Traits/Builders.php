<?php

namespace App\Livewire\Traits;

use App\Enums\AssetType;
use App\Models\Asset;
use App\Models\CityAsset;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;

/**
 * @property Collection $buildings
 */
trait Builders
{
    public int $builders;

    public int $chosenBuildingId = 0;

    #[Computed]
    public function buildings(): Collection
    {
        $finishedBuildings = Asset::whereRelation('cityAsset', 'city_id', '=', $this->city->id)
            ->whereRelation('cityAsset', 'city_asset.xp', '=', DB::raw('assets.xp'))
            ->get('id')
            ->pluck('id');

        return Asset::with('cityAsset')

            ->where('type', AssetType::Building->value)
            ->whereNotIn('id', $finishedBuildings)
            ->where(function (Builder $q) use ($finishedBuildings) {
                $q->whereIn('parent_id', $finishedBuildings)
                    ->orWhereNull('parent_id');
            })
            ->orderBy('name')
            ->get();
    }

    public function progressBuilding(): void
    {
        if ($this->chosenBuildingId !== 0) {
            $xp = $this->builders * config('game.base_work_per_turn');

            $asset = Asset::find($this->chosenBuildingId);
            $buildingInProgress = CityAsset::where([
                'city_id' => $this->city->id,
                'asset_id' => $this->chosenBuildingId,
            ])->first();

            $newProgress = ($buildingInProgress->xp ?? 0) + $xp;

            // Finish
            if ($newProgress >= $asset->xp) {
                $newProgress = $asset->xp;

                $xp = $asset->xp - ($buildingInProgress->xp ?? 0);

                $this->chosenBuildingId = 0;
            }

            CityAsset::upsert([
                'xp' => $newProgress,
                'city_id' => $this->city->id,
                'asset_id' => $asset->id,
            ], [
                'city_id',
                'asset_id',
            ], [
                'xp',
            ]);

            Session::push('messages', "Builders built $xp of $asset->name.");
        }
    }
}