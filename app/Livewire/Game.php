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
            $xp = $this->builders * config('game.base_work_per_turn');

            $asset = Asset::find($this->chosenBuildingId);
            $buildingInProgress = CityAsset::where([
                'city_id' => $this->cityId,
                'asset_id' => $this->chosenBuildingId,
            ])->first();

            $newProgress = ($buildingInProgress->xp ?? 0) + $xp;

            // Finish
            if ($newProgress >= $asset->xp) {
                $newProgress = $asset->xp;

                $xp = $asset->xp - ($buildingInProgress->xp ?? 0);

                $this->chosenBuildingId = 0;
            }

            CityAsset::upsert([
                'xp' => $newProgress,
                'city_id' => $this->cityId,
                'asset_id' => $asset->id,
            ], [
                'city_id',
                'asset_id',
            ], [
                'xp',
            ]);

            Session::push('messages', "Builders built $xp of $asset->name.");
        }

        // Technology
        if ($this->workshopIsBuilt) {
            if ($this->chosenTechnologyId !== 0) {
                $xp = $this->engineers * config('game.base_work_per_turn');

                $asset = Asset::find($this->chosenTechnologyId);
                $technologyInProgress = CityAsset::where([
                    'city_id' => $this->cityId,
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
                    'city_id' => $this->cityId,
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

        // Research
        if ($this->laboratoryIsBuilt) {
            if ($this->chosenResearchId !== 0) {
                $xp = $this->scientists * config('game.base_work_per_turn');

                $asset = Asset::find($this->chosenResearchId);
                $researchInProgress = CityAsset::where([
                    'city_id' => $this->cityId,
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
                    'city_id' => $this->cityId,
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
