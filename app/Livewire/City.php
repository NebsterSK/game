<?php

namespace App\Livewire;

use App\Enums\PopulationType;
use App\Models\City as CityModel;
use Livewire\Attributes\Computed;
use Livewire\Component;

/**
 * @property CityModel $city
 */
class City extends Component
{
    public string $cityId;

    public int $population = 10;
    public int $builders = 0;
    public int $engineers = 0;
    public int $scientists = 0;

    public function mount(): void
    {
        $this->population = $this->city->population;
        $this->builders = $this->city->builders;
        $this->engineers = $this->city->engineers;
        $this->scientists = $this->city->scientists;
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
        $this->city->update([
            'turn' => $this->city->turn + 1,
            'population' => $this->population,
            'builders' => $this->builders,
            'engineers' => $this->engineers,
            'scientists' => $this->scientists,
        ]);
    }

    public function resetCity(): void
    {
        $this->city->update([
            'turn' => 0,
            'population' => 10,
            'builders' => 0,
            'engineers' => 0,
            'scientists' => 0,
        ]);

        $this->reset();
    }
}
