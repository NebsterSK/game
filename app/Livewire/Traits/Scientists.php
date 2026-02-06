<?php

namespace App\Livewire\Traits;

use App\Enums\AssetType;
use App\Models\Asset;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

/**
 * @property Collection $researches
 * @property bool $laboratoryIsBuilt
 */
trait Scientists
{
    public int $scientists;

    public int $chosenResearchId = 0;

    #[Computed]
    public function researches(): Collection
    {
        $finishedResearches = Asset::whereRelation('colonyAsset', 'colony_id', '=', $this->colony->id)
            ->whereRelation('colonyAsset', 'colony_asset.xp', '=', DB::raw('assets.xp'))
            ->get('id')
            ->pluck('id');

        return Asset::with('colonyAsset')
            ->where('type', AssetType::Research->value)
            ->whereNotIn('id', $finishedResearches)
            ->where(function (Builder $q) use ($finishedResearches) {
                $q->whereIn('parent_id', $finishedResearches)
                    ->orWhereNull('parent_id');
            })
            ->orderBy('name')
            ->get();
    }

    #[Computed]
    public function laboratoryIsBuilt(): bool
    {
        return Asset::where('id', 3)
            ->whereRelation('colonyAsset', 'colony_id', '=', $this->colony->id)
            ->whereRelation('colonyAsset', 'colony_asset.xp', '=', DB::raw('assets.xp'))
            ->exists();
    }
}