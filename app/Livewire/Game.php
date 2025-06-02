<?php

namespace App\Livewire;

use App\Enums\AssetType;
use App\Enums\PopulationType;
use App\Models\Asset;
use App\Models\City;
use App\Models\CityAsset;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property City $city
 */
class Game extends Component
{
    public string $cityId;

    public int $population;
    public int $builders;
    public int $engineers;
    public int $scientists;

    public int $chosenBuildingId = 0;
    public int $chosenTechnologyId = 0;
    public int $chosenResearchId = 0;

    public function mount(): void
    {
        $this->population = $this->city->population;
        $this->builders = $this->city->builders;
        $this->engineers = $this->city->engineers;
        $this->scientists = $this->city->scientists;
    }

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

    public function increment(string $type): void
    {
        if ($this->population === 0) {
            return;
        }

        switch ($type) {
            case PopulationType::Builder->value:
                $this->population--;
                $this->builders++;

                break;

            case PopulationType::Engineer->value:
                $this->population--;
                $this->engineers++;

                break;

            case PopulationType::Scientist->value:
                $this->population--;
                $this->scientists++;

                break;
        }
    }

    public function decrement(string $type): void
    {
        switch ($type) {
            case PopulationType::Builder->value:
                if ($this->builders === 0) {
                    return;
                }

                $this->population++;
                $this->builders--;

                break;

            case PopulationType::Engineer->value:
                if ($this->engineers === 0) {
                    return;
                }

                $this->population++;
                $this->engineers--;

                break;

            case PopulationType::Scientist->value:
                if ($this->scientists === 0) {
                    return;
                }

                $this->population++;
                $this->scientists--;

                break;
        }
    }

    public function endTurn(): void
    {
        Session::remove('messages');

        $this->city->update([
            'turn' => $this->city->turn + 1,
            'population' => $this->population,
            'builders' => $this->builders,
            'engineers' => $this->engineers,
            'scientists' => $this->scientists,
        ]);

        if ($this->population > 0) {
            Session::push('messages', 'We have available population that is not assigned to any role.');
        }

        // Building
        if ($this->chosenBuildingId !== 0) {
            $progress = $this->builders * 10;
            $buildingInProgress = CityAsset::where([
                'city_id' => $this->cityId,
                'asset_id' => $this->chosenBuildingId,
            ])->with('asset')->first();
            $newProgress = ($buildingInProgress->xp ?? 0) + $progress;

            if ($buildingInProgress) {
                if ($newProgress >= $buildingInProgress->asset->xp) {
                    $xp = $buildingInProgress->asset->xp;

                    Session::push('messages', 'Builders finished building ' . $buildingInProgress->asset->name . '.');
                } else {
                    $xp = $newProgress;

                    Session::push('messages', 'Builders built ' . $progress . ' of ' . $buildingInProgress->asset->name . '.');
                }

                $buildingInProgress->update([
                    'xp' => $xp,
                ]);
            } else {
                $cityAsset = CityAsset::create([
                    'city_id' => $this->cityId,
                    'asset_id' => $this->chosenBuildingId,
                    'xp' => $progress,
                ]);

                $cityAsset->load('asset');

                Session::push('messages', 'Builders built ' . $progress . ' of ' . $cityAsset->asset->name . '.');
            }
        } else {
            Session::push('messages', 'Builders didn\'t build anything.');
        }

        // Technology
        if ($this->workshopIsBuilt) {
            if ($this->chosenTechnologyId !== 0) {
                $progress = $this->engineers * 10;
                $technologyInProgress = CityAsset::where([
                    'city_id' => $this->cityId,
                    'asset_id' => $this->chosenTechnologyId,
                ])->with('asset')->first();
                $newProgress = ($technologyInProgress->xp ?? 0) + $progress;

                if ($technologyInProgress) {
                    if ($newProgress >= $technologyInProgress->asset->xp) {
                        $xp = $technologyInProgress->asset->xp;

                        Session::push('messages', 'Engineers finished researching ' . $technologyInProgress->asset->name . '.');
                    } else {
                        $xp = $newProgress;

                        Session::push('messages', 'Engineers researched ' . $progress . ' of ' . $technologyInProgress->asset->name . '.');
                    }

                    $technologyInProgress->update([
                        'xp' => $xp,
                    ]);
                } else {
                    $cityAsset = CityAsset::create([
                        'city_id' => $this->cityId,
                        'asset_id' => $this->chosenTechnologyId,
                        'xp' => $progress,
                    ]);

                    $cityAsset->load('asset');

                    Session::push('messages', 'Engineers researched ' . $progress . ' of ' . $cityAsset->asset->name . '.');
                }
            } else {
                Session::push('messages', 'Engineers didn\'t research anything.');
            }
        }

        // Research
        if ($this->laboratoryIsBuilt) {
            if ($this->chosenResearchId !== 0) {
                $progress = $this->scientists * 10;
                $researchInProgress = CityAsset::where([
                    'city_id' => $this->cityId,
                    'asset_id' => $this->chosenResearchId,
                ])->with('asset')->first();
                $newProgress = ($researchInProgress->xp ?? 0) + $progress;

                if ($researchInProgress) {
                    if ($newProgress >= $researchInProgress->asset->xp) {
                        $xp = $researchInProgress->asset->xp;

                        Session::push('messages', 'Scientists finished researching ' . $researchInProgress->asset->name . '.');
                    } else {
                        $xp = $newProgress;

                        Session::push('messages', 'Scientists researched ' . $progress . ' of ' . $researchInProgress->asset->name . '.');
                    }

                    $researchInProgress->update([
                        'xp' => $xp,
                    ]);
                } else {
                    $cityAsset = CityAsset::create([
                        'city_id' => $this->cityId,
                        'asset_id' => $this->chosenResearchId,
                        'xp' => $progress,
                    ]);

                    $cityAsset->load('asset');

                    Session::push('messages', 'Scientists researched ' . $progress . ' of ' . $cityAsset->asset->name . '.');
                }
            } else {
                Session::push('messages', 'Scientists didn\'t research anything.');
            }
        }
    }

    public function resetCity(): void
    {
        Session::remove('messages');

        $this->city->update([
            'turn' => 0,
            'population' => 10,
            'builders' => 0,
            'engineers' => 0,
            'scientists' => 0,
        ]);

        $this->city->cityAssets()->delete();

        $this->mount();
    }
}
