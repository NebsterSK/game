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

                <label class="input-group-text">work on</label>

                <select
                        wire:model="chosenBuildingId"
                        wire:loading.attr="disabled"
                        class="form-select"
                >
                    <option value="0">Nothing</option>
                    @foreach($this->buildings as $building)
                        <option wire:key="{{ $building->id }}" value="{{ $building->id }}">{{ $building->name }} | {{ $building->cityAsset->xp ?? 0 }} / {{ $building->xp }}</option>
                    @endforeach
                </select>
            </div>

            @if($this->workshopIsBuilt)
                <div class="input-group mb-3">
                    <span class="input-group-text">Engineers</span>

                    <button
                            wire:click="decrement('{{ PopulationType::Engineer->value }}')"
                            wire:loading.attr="disabled"
                            class="btn btn-outline-secondary"
                    >-</button>

                    <span class="input-group-text">{{ $this->engineers }}</span>

                    <button
                            wire:click="increment('{{ PopulationType::Engineer->value }}')"
                            wire:loading.attr="disabled"
                            class="btn btn-outline-secondary"
                    >+</button>

                    <label class="input-group-text">work on</label>

                    <select
                            wire:model="chosenTechnologyId"
                            wire:loading.attr="disabled"
                            class="form-select"
                    >
                        <option value="0">Nothing</option>
                        @foreach($this->technologies as $technology)
                            <option wire:key="{{ $technology->id }}" value="{{ $technology->id }}">{{ $technology->name }} | {{ $technology->cityAsset->xp ?? 0 }} / {{ $technology->xp }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        <div class="col-6">
            @if(\Illuminate\Support\Facades\Session::has('messages'))
                <ul>
                    @foreach(\Illuminate\Support\Facades\Session::get('messages') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

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
