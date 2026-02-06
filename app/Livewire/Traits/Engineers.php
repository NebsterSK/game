<?php

namespace App\Livewire\Traits;

use App\Enums\AssetType;
use App\Models\Asset;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

/**
 * @property Collection $technologies
 * @property bool $workshopIsBuilt
 */
trait Engineers
{
    public int $engineers;

    public int $chosenTechnologyId = 0;

    #[Computed]
    public function technologies(): Collection
    {
        $finishedTechnologies = Asset::whereRelation('colonyAsset', 'colony_id', '=', $this->colony->id)
            ->whereRelation('colonyAsset', 'colony_asset.xp', '=', DB::raw('assets.xp'))
            ->get('id')
            ->pluck('id');

        return Asset::with('colonyAsset')
            ->where('type', AssetType::Technology->value)
            ->whereNotIn('id', $finishedTechnologies)
            ->where(function (Builder $q) use ($finishedTechnologies) {
                $q->whereIn('parent_id', $finishedTechnologies)
                    ->orWhereNull('parent_id');
            })
            ->orderBy('name')
            ->get();
    }

    #[Computed]
    public function workshopIsBuilt(): bool
    {
        return Asset::where('id', 2)
            ->whereRelation('colonyAsset', 'colony_id', '=', $this->colony->id)
            ->whereRelation('colonyAsset', 'colony_asset.xp', '=', DB::raw('assets.xp'))
            ->exists();
    }
}