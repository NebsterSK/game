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
 * @property Collection $technologies
 * @property bool $workshopIsBuilt
 */
trait Engineers
{
    #[Validate('required|integer|min:0')]
    public int $engineers = 0;

    public int $chosenTechnologyId = 0;

    #[Computed]
    public function availableTechnologies(): Collection
    {
        $finishedTechnologyIds = $this->finishedAssets->pluck('id');

        return Asset::with('colonyAsset')
            ->where('type', AssetType::Technology->value)
            ->whereNotIn('id', $finishedTechnologyIds)
            ->where(function (Builder $q) use ($finishedTechnologyIds) {
                $q->whereIn('parent_id', $finishedTechnologyIds)
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
