@use(App\Enums\PopulationType)
@use(Illuminate\Support\Carbon)

<div>
    <h1>{{ $this->city->name }}</h1>

    <p>Turn: {{ $this->city->turn }} | Earth date: {{ Carbon::make('2028-02-18')->addDays($this->city->turn * 10)->toDateString() }}</p>

    <hr>

    <div class="row">
        <div class="col-6">
            <p>Available population: {{ $this->population }}</p>

            <div class="input-group mb-3">
                <span class="input-group-text">Builders</span>

                <button
                        wire:click="decrement('{{ PopulationType::Builder->value }}')"
                        wire:loading.attr="disabled"
                        class="btn btn-outline-secondary"
                >-</button>

                <span class="input-group-text">{{ $this->builders }}</span>

                <button
                        wire:click="increment('{{ PopulationType::Builder->value }}')"
                        wire:loading.attr="disabled"
                        class="btn btn-outline-secondary"
                >+</button>

                <label class="input-group-text" for="inputGroupSelect01">work on</label>

                <select
                        wire:model="chosenBuildingId"
                        wire:loading.attr="disabled"
                        class="form-select"
                >
                    <option value="0">Nothing</option>
                    @foreach($this->buildings as $building)
                        <option wire:key="{{ $building->id }}" value="{{ $building->id }}">{{ $building->name }} | Progress: ? / {{ $building->xp }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-6">
            @if(\Illuminate\Support\Facades\Session::has('messages'))
                @foreach(\Illuminate\Support\Facades\Session::get('messages') as $message)
                    <p>{{ $message }}</p>
                @endforeach
            @endif
        </div>
    </div>

{{--    <p>--}}
{{--        Engineers--}}

{{--        <button wire:click="decrement('{{ PopulationType::Engineer->value }}')" class="btn btn-secondary">-</button>--}}
{{--        <input value="{{ $this->engineers }}" type="number" min="0" disabled />--}}
{{--        <button wire:click="increment('{{ PopulationType::Engineer->value }}')" class="btn btn-secondary">+</button>--}}

{{--        <select>--}}
{{--            <option value="">Solar panels</option>--}}
{{--            <option value="">Antena</option>--}}
{{--            <option value="">Telescope</option>--}}
{{--            <option value="">Rover</option>--}}
{{--        </select>--}}
{{--    </p>--}}

{{--    <p>--}}
{{--        Scientists--}}

{{--        <button wire:click="decrement('{{ PopulationType::Scientist->value }}')" class="btn btn-secondary">-</button>--}}
{{--        <input value="{{ $this->scientists }}" type="number" min="0" disabled />--}}
{{--        <button wire:click="increment('{{ PopulationType::Scientist->value }}')" class="btn btn-secondary">+</button>--}}

{{--        <select>--}}
{{--            <option value="">Soil samples</option>--}}
{{--            <option value="">Atmosphere composition</option>--}}
{{--        </select>--}}
{{--    </p>--}}

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
