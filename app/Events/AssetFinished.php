<?php

namespace App\Events;

use App\Models\Asset;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AssetFinished
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Asset $asset) {}
}
