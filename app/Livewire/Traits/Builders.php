<?php

namespace App\Livewire\Traits;

use App\Enums\AssetType;
use App\Models\Asset;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;

/**
 * @property Collection $buildings
 */
trait Builders
{
    #[Validate('required|integer|min:0')]
    public int $builders = 0;

    public int $chosenBuildingId = 0;

    #[Computed]
    public function availableBuildings(): Collection
    {
        $finishedBuildingIds = $this->finishedAssets->pluck('id');

        return Asset::with('colonyAsset')
            ->where('type', AssetType::Building->value)
            ->whereNotIn('id', $finishedBuildingIds)
            ->where(function (Builder $q) use ($finishedBuildingIds) {
                $q->whereIn('parent_id', $finishedBuildingIds)
                    ->orWhereNull('parent_id');
            })
            ->orderBy('name')
            ->get();
    }
}
