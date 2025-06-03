<?php

namespace App\Livewire;

use App\Enums\AssetType;
use App\Enums\PopulationType;
use App\Livewire\Traits\ComputedProperties;
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
 * @property Collection $buildings
 * @property Collection $technologies
 * @property Collection $researches
 * @property Collection $workshopIsBuilt
 * @property Collection $laboratoryIsBuilt
 */
class Game extends Component
{
    use ComputedProperties;

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

            // TODO: Fix ked je dokoncene na jeden tah
            if ($buildingInProgress) {
                if ($newProgress >= $buildingInProgress->asset->xp) {
                    $xp = $buildingInProgress->asset->xp;

                    $this->chosenBuildingId = 0;

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

                // TODO: Fix ked je dokoncene na jeden tah
                if ($technologyInProgress) {
                    if ($newProgress >= $technologyInProgress->asset->xp) {
                        $xp = $technologyInProgress->asset->xp;

                        $this->chosenTechnologyId = 0;

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

                // TODO: Fix ked je dokoncene na jeden tah
                if ($researchInProgress) {
                    if ($newProgress >= $researchInProgress->asset->xp) {
                        $xp = $researchInProgress->asset->xp;

                        $this->chosenResearchId = 0;

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
