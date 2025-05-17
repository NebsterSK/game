<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;

class Base extends Component
{
    public array $messages = [];

    public int $builders = 0;

//    public function decreaseBuilders(): void
//    {
//        $this->builders--;
//    }
//
//    public function increaseBuilders(): void
//    {
//        $this->builders++;
//    }

    public function endTurn(): void
    {
        $this->messages[] = 'Last day we did...';
    }
}
