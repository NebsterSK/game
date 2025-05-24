<?php

namespace App\Livewire;

use Livewire\Component;

class Base extends Component
{
    public array $messages = [];

    public int $builders = 0;
    public int $engineers = 0;
    public int $scientists = 0;

    public function endTurn(): void
    {
        $this->messages = [];

        $this->messages[] = 'Last day we did...';
    }
}
