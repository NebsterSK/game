@use(App\Enums\PopulationType)
@use(Illuminate\Support\Carbon)

<div>
    <h1>{{ $this->city->name }}</h1>

    <p>Turn: {{ $this->city->turn }} | Earth date: {{ Carbon::make('2028-02-18')->addDays($this->city->turn * 10)->toDateString() }}</p>

    <hr>

{{--    <div>--}}
{{--        @foreach($messages as $message)--}}
{{--            <p>{{ $message }}</p>--}}
{{--        @endforeach--}}
{{--    </div>--}}

    <hr>

    <p>Population: {{ $this->population }}</p>

    <p>
        Builders

        <button wire:click="decrement('{{ PopulationType::Builder->value }}')" class="btn btn-secondary">-</button>
        <input value="{{ $this->builders }}" type="number" min="0" disabled />
        <button wire:click="increment('{{ PopulationType::Builder->value }}')" class="btn btn-secondary">+</button>

{{--        <select>--}}
{{--            <option value="">Housing</option>--}}
{{--            <option value="">Workshop</option>--}}
{{--            <option value="">Laboratory</option>--}}
{{--            <option value="">Headquarters</option>--}}
{{--            <option value="">Warehouse</option>--}}
{{--        </select>--}}
    </p>

    <p>
        Engineers

        <button wire:click="decrement('{{ PopulationType::Engineer->value }}')" class="btn btn-secondary">-</button>
        <input value="{{ $this->engineers }}" type="number" min="0" disabled />
        <button wire:click="increment('{{ PopulationType::Engineer->value }}')" class="btn btn-secondary">+</button>

{{--        <select>--}}
{{--            <option value="">Solar panels</option>--}}
{{--            <option value="">Antena</option>--}}
{{--            <option value="">Telescope</option>--}}
{{--            <option value="">Rover</option>--}}
{{--        </select>--}}
    </p>

    <p>
        Scientists

        <button wire:click="decrement('{{ PopulationType::Scientist->value }}')" class="btn btn-secondary">-</button>
        <input value="{{ $this->scientists }}" type="number" min="0" disabled />
        <button wire:click="increment('{{ PopulationType::Scientist->value }}')" class="btn btn-secondary">+</button>

{{--        <select>--}}
{{--            <option value="">Soil samples</option>--}}
{{--            <option value="">Atmosphere composition</option>--}}
{{--        </select>--}}
    </p>

    <hr>

    <div class="d-flex justify-content-between">
        <button
            wire:click="resetCity"
            wire:confirm="Sure?"
            class="btn btn-danger"
        >Reset city</button>

        <button
            wire:click="endTurn"
            wire:loading.attr="disabled"
            class="btn btn-primary"
        >End turn</button>
    </div>
</div>
