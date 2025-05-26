<?php

namespace App\Livewire;

use App\Models\City as CityModel;
use Livewire\Component;

class City extends Component
{
    protected CityModel $city;

    public int $builders = 0;
    public int $engineers = 0;
    public int $scientists = 0;

    public function mount(CityModel $city): void
    {
        $this->city = $city;
    }

    public function endTurn(): void
    {
//        $this->city->update([
//            'turn' => $this->city->turn++,
//        ]);
    }
}
