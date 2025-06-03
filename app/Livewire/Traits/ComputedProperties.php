<?php

namespace App\Livewire\Traits;

use App\Enums\AssetType;
use App\Models\Asset;
use App\Models\City;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;

trait ComputedProperties
{
    #[Computed]
    public function city(): City
    {
        return City::find($this->cityId);
    }

    #[Computed]
    public function buildings(): Collection
    {
        $finishedBuildings = Asset::whereRelation('cityAsset', 'city_id', '=', $this->cityId)
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
            ->get();
    }

    #[Computed]
    public function technologies(): Collection
    {
        $finishedTechnologies = Asset::whereRelation('cityAsset', 'city_id', '=', $this->cityId)
            ->whereRelation('cityAsset', 'city_asset.xp', '=', DB::raw('assets.xp'))
            ->get('id')
            ->pluck('id');

        return Asset::with('cityAsset')

            ->where('type', AssetType::Technology->value)
            ->whereNotIn('id', $finishedTechnologies)
            ->where(function (Builder $q) use ($finishedTechnologies) {
                $q->whereIn('parent_id', $finishedTechnologies)
                    ->orWhereNull('parent_id');
            })
            ->get();
    }

    #[Computed]
    public function researches(): Collection
    {
        $finishedResearches = Asset::whereRelation('cityAsset', 'city_id', '=', $this->cityId)
            ->whereRelation('cityAsset', 'city_asset.xp', '=', DB::raw('assets.xp'))
            ->get('id')
            ->pluck('id');

        return Asset::with('cityAsset')

            ->where('type', AssetType::Research->value)
            ->whereNotIn('id', $finishedResearches)
            ->where(function (Builder $q) use ($finishedResearches) {
                $q->whereIn('parent_id', $finishedResearches)
                    ->orWhereNull('parent_id');
            })
            ->get();
    }

    #[Computed]
    public function workshopIsBuilt(): bool
    {
        return Asset::where('id', 2)
            ->whereRelation('cityAsset', 'city_id', '=', $this->cityId)
            ->whereRelation('cityAsset', 'city_asset.xp', '=', DB::raw('assets.xp'))
            ->exists();
    }

    #[Computed]
    public function laboratoryIsBuilt(): bool
    {
        return Asset::where('id', 3)
            ->whereRelation('cityAsset', 'city_id', '=', $this->cityId)
            ->whereRelation('cityAsset', 'city_asset.xp', '=', DB::raw('assets.xp'))
            ->exists();
    }
}