<?php

namespace App\Livewire;

use App\Livewire\Traits\Builders;
use App\Livewire\Traits\Engineers;
use App\Livewire\Traits\Scientists;
use App\Models\City;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Game extends Component
{
    use Builders;
//    use General;
    use Engineers;
    use Scientists;

    public City $city;

    public int $population;

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

        $this->progressBuilding();

        if ($this->workshopIsBuilt) {
            $this->progressTechnology();
        }

        if ($this->laboratoryIsBuilt) {
            $this->progressResearch();
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
