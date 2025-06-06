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
        $finishedResearches = Asset::whereRelation('cityAsset', 'city_id', '=', $this->city->id)
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
            ->orderBy('name')
            ->get();
    }

    #[Computed]
    public function laboratoryIsBuilt(): bool
    {
        return Asset::where('id', 3)
            ->whereRelation('cityAsset', 'city_id', '=', $this->city->id)
            ->whereRelation('cityAsset', 'city_asset.xp', '=', DB::raw('assets.xp'))
            ->exists();
    }

    protected function progressResearch(): void
    {
        if ($this->chosenResearchId !== 0) {
            $xp = $this->scientists * config('game.base_work_per_turn');

            $asset = Asset::find($this->chosenResearchId);
            $researchInProgress = CityAsset::where([
                'city_id' => $this->city->id,
                'asset_id' => $this->chosenResearchId,
            ])->first();

            $newProgress = ($researchInProgress->xp ?? 0) + $xp;

            // Finish
            if ($newProgress >= $asset->xp) {
                $newProgress = $asset->xp;

                $xp = $asset->xp - ($researchInProgress->xp ?? 0);

                $this->chosenResearchId = 0;
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

            Session::push('messages', "Scientists researched $xp of $asset->name.");
        }
    }
}