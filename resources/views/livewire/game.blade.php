@use(Illuminate\Support\Carbon)
@use(Illuminate\Support\Facades\Auth)

<div>
    <h1>{{ $this->colony->name }}</h1>

    <p class="lead mb-0">Commander: {{ Auth::user()->name }}</p>

{{--    <p>Turn: {{ $this->colony->turn }} | Earth date: {{ Carbon::make(config('game.starting_earth_date'))->addDays($this->colony->turn * 10)->toDateString() }}</p>--}}
    <p>Turn: {{ $this->colony->turn }}</p>

    <hr>

    <div class="row">
        <div class="col-8">
            <h2>Crew</h2>

            <p>Resting: <span x-text="$wire.population"></span></p>

            @include('livewire.includes.builders')

            @include('livewire.includes.engineers')

            @include('livewire.includes.scientists')
        </div>

        <div class="col-4">
            <h2>Log</h2>

            @include('livewire.includes.log')
        </div>
    </div>

    <hr>

    <div class="d-flex justify-content-between">
        @if(config('app.debug'))
        <button
            wire:click="resetColony"
            wire:confirm="Sure?"
            wire:loading.attr="disabled"
            class="btn btn-danger"
        >Reset colony</button>
        @endif

        <button
            wire:click="endTurn"
            wire:loading.attr="disabled"
            class="btn btn-primary"
        >End turn</button>
    </div>
</div>

@script
<script>
    $wire.$js.decreaseRole = function (role) {
        if ($wire[role] > 0) {
            $wire[role]--;
            $wire.population++;
        }
    };

    $wire.$js.increaseRole = function (role) {
        if ($wire.population > 0) {
            $wire[role]++;
            $wire.population--;
        }
    };
</script>
@endscript