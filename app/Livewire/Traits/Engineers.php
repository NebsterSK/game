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
        $finishedTechnologies = Asset::whereRelation('cityAsset', 'city_id', '=', $this->city->id)
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
            ->orderBy('name')
            ->get();
    }

    #[Computed]
    public function workshopIsBuilt(): bool
    {
        return Asset::where('id', 2)
            ->whereRelation('cityAsset', 'city_id', '=', $this->city->id)
            ->whereRelation('cityAsset', 'city_asset.xp', '=', DB::raw('assets.xp'))
            ->exists();
    }

    protected function progressTechnology(): void
    {
        if ($this->chosenTechnologyId !== 0) {
            $xp = $this->engineers * config('game.base_work_per_turn');

            $asset = Asset::find($this->chosenTechnologyId);
            $technologyInProgress = CityAsset::where([
                'city_id' => $this->city->id,
                'asset_id' => $this->chosenTechnologyId,
            ])->first();

            $newProgress = ($technologyInProgress->xp ?? 0) + $xp;

            // Finish
            if ($newProgress >= $asset->xp) {
                $newProgress = $asset->xp;

                $xp = $asset->xp - ($technologyInProgress->xp ?? 0);

                $this->chosenTechnologyId = 0;
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

            Session::push('messages', "Engineers developed $xp of $asset->name.");
        }
    }
}