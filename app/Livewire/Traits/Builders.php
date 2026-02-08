<?php

namespace App\Livewire\Traits;

use App\Enums\AssetType;
use App\Models\Asset;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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
        $finishedBuildings = Asset::whereRelation('colonyAsset', 'colony_id', '=', $this->colony->id)
            ->whereRelation('colonyAsset', 'colony_asset.xp', '=', DB::raw('assets.xp'))
            ->get('id')
            ->pluck('id');

        return Asset::with('colonyAsset')
            ->where('type', AssetType::Building->value)
            ->whereNotIn('id', $finishedBuildings)
            ->where(function (Builder $q) use ($finishedBuildings) {
                $q->whereIn('parent_id', $finishedBuildings)
                    ->orWhereNull('parent_id');
            })
            ->orderBy('name')
            ->get();
    }
}
