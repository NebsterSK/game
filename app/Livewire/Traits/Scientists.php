<?php

namespace App\Livewire\Traits;

use App\Enums\AssetType;
use App\Models\Asset;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;

/**
 * @property Collection $researches
 * @property bool $laboratoryIsBuilt
 */
trait Scientists
{
    #[Validate('required|integer|min:0')]
    public int $scientists = 0;

    public int $chosenResearchId = 0;

    #[Computed]
    public function availableResearches(): Collection
    {
        $finishedResearchIds = $this->finishedAssets->pluck('id');

        return Asset::with('colonyAsset')
            ->where('type', AssetType::Research->value)
            ->whereNotIn('id', $finishedResearchIds)
            ->where(function (Builder $q) use ($finishedResearchIds) {
                $q->whereIn('parent_id', $finishedResearchIds)
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
