<?php

namespace App\Livewire;

use App\Enums\AssetType;
use App\Enums\PopulationType;
use App\Models\Asset;
use App\Models\City as CityModel;
use App\Models\CityAsset;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property CityModel $city
 */
class Game extends Component
{
    public string $cityId;

    public int $population;
    public int $builders;
    public int $engineers;
    public int $scientists;

    public Collection $buildings;
    public int $chosenBuildingId = 0;

    public function mount(): void
    {
        $this->population = $this->city->population;
        $this->builders = $this->city->builders;
        $this->engineers = $this->city->engineers;
        $this->scientists = $this->city->scientists;

        $assets = Asset::get();
        $this->buildings = $assets->where('type', AssetType::Building->value);
    }

    #[Computed]
    public function city(): CityModel
    {
        return CityModel::find($this->cityId);
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

                    Session::push('messages', 'We finished building ...');
                } else {
                    $xp = $newProgress;

                    Session::push('messages', 'We built ...');
                }

                $buildingInProgress->update([
                    'xp' => $xp,
                ]);
            } else {
                CityAsset::create([
                    'city_id' => $this->cityId,
                    'asset_id' => $this->chosenBuildingId,
                    'xp' => $progress,
                ]);

                Session::push('messages', 'We built ...');
            }
        } else {
            Session::push('messages', 'We didn\'t build anything.');
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
