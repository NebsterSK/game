<?php

namespace App\Livewire;

use App\Livewire\Traits\Builders;
use App\Livewire\Traits\Engineers;
use App\Livewire\Traits\Scientists;
use App\Models\Colony;
use Illuminate\Database\Eloquent\Casts\ArrayObject;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class Game extends Component
{
    use Builders;
    use Engineers;
    use Scientists;

    public Colony $colony;

    public int $population;
    public int $power;

    public function mount(): void
    {
        $this->population = $this->colony->params->population;
        $this->builders = $this->colony->params->builders;
        $this->engineers = $this->colony->params->engineers;
        $this->scientists = $this->colony->params->scientists;

        $this->power = $this->colony->params->power;
    }

    public function endTurn(): void
    {
        Session::remove('messages');

        $this->colony->turn = $this->colony->turn + 1;
        $this->colony->params->population = $this->population;
        $this->colony->params->builders = $this->builders;
        $this->colony->params->engineers = $this->engineers;
        $this->colony->params->scientists = $this->scientists;
        $this->colony->params->power = $this->power;
        $this->colony->save();

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

    public function resetColony(): void
    {
        Session::remove('messages');

        $this->colony->turn = 0;
        $this->colony->params->population = 10;
        $this->colony->params->builders = 0;
        $this->colony->params->engineers = 0;
        $this->colony->params->scientists = 0;
        $this->colony->params->power = 10;
        $this->colony->save();

        $this->colony->colonyAssets()->delete();

        $this->mount();
    }
}
