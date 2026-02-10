<?php

namespace App\Livewire;

use App\Events\TurnEnded;
use App\Livewire\Traits\Builders;
use App\Livewire\Traits\Engineers;
use App\Livewire\Traits\Scientists;
use App\Models\Asset;
use App\Models\Colony;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;

/**
 * @property Collection $finishedAssets
 */
class Game extends Component
{
    use Builders;
    use Engineers;
    use Scientists;

    #[Locked]
    public Colony $colony;

    #[Validate('required|integer|min:0')]
    public int $population;

    public function mount(): void
    {
        $this->population = $this->colony->population;
        $this->builders = $this->colony->builders;
        $this->engineers = $this->colony->engineers;
        $this->scientists = $this->colony->scientists;
    }

    public function endTurn(): void
    {
        TurnEnded::dispatch($this);
    }

    public function resetColony(): void
    {
        Session::remove('messages');

        $this->colony->update([
            'turn' => 0,
            'population' => 10,
            'builders' => 0,
            'engineers' => 0,
            'scientists' => 0,
        ]);

        $this->colony->colonyAssets()->delete();

        $this->mount();
    }

    #[Computed]
    public function finishedAssets(): Collection
    {
        return Asset::whereRelation('colonyAsset', 'colony_id', '=', $this->colony->id)
            ->whereRelation('colonyAsset', 'colony_asset.xp', '=', DB::raw('assets.xp'))
            ->get();
    }
}
