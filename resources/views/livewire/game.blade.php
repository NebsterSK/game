@use(Illuminate\Support\Carbon)

<div>
    <h1>{{ $this->city->name }}</h1>

    <p>Turn: {{ $this->city->turn }} | Earth date: {{ Carbon::make(config('game.starting_earth_date'))->addDays($this->city->turn * 10)->toDateString() }}</p>

    <hr>

    <div class="row">
        <div
            class="col-6"
        >
            <p>Available population: <span x-text="$wire.population"></span></p>

            <div class="input-group mb-3">
                <span class="input-group-text">Builders</span>

                <button
                    x-on:click="if ($wire.builders > 0) {$wire.builders--;$wire.population++}"
                    class="btn btn-outline-primary"
                >-</button>

                <span
                    x-text="$wire.builders"
                    class="input-group-text"
                ></span>

                <button
                    x-on:click="if ($wire.population > 0) {$wire.builders++;$wire.population--}"
                    class="btn btn-outline-primary"
                >+</button>

                <label class="input-group-text">build</label>

                <select
                    wire:model="chosenBuildingId"
                    wire:loading.attr="disabled"
                    class="form-select"
                >
                    <option value="0">Nothing</option>
                    @foreach($this->buildings as $building)
                        <option wire:key="{{ $building->id }}" value="{{ $building->id }}">{{ $building->name }} | Progress: {{ $building->cityAsset->xp ?? 0 }} / {{ $building->xp }}</option>
                    @endforeach
                </select>
            </div>

            @if($this->workshopIsBuilt)
                <div class="input-group mb-3">
                    <span class="input-group-text">Engineers</span>

                    <button
                        x-on:click="if ($wire.engineers > 0) {$wire.engineers--;$wire.population++}"
                        class="btn btn-outline-primary"
                    >-</button>

                    <span
                        x-text="$wire.engineers"
                        class="input-group-text"
                    ></span>

                    <button
                        x-on:click="if ($wire.population > 0) {$wire.engineers++;$wire.population--}"
                        class="btn btn-outline-primary"
                    >+</button>

                    <label class="input-group-text">develop</label>

                    <select
                        wire:model="chosenTechnologyId"
                        wire:loading.attr="disabled"
                        class="form-select"
                    >
                        <option value="0">Nothing</option>
                        @foreach($this->technologies as $technology)
                            <option wire:key="{{ $technology->id }}" value="{{ $technology->id }}">{{ $technology->name }} | Progress: {{ $technology->cityAsset->xp ?? 0 }} / {{ $technology->xp }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if($this->laboratoryIsBuilt)
                <div class="input-group mb-3">
                    <span class="input-group-text">Scientists</span>

                    <button
                        x-on:click="if ($wire.scientists > 0) {$wire.scientists--;$wire.population++}"
                        class="btn btn-outline-primary"
                    >-</button>

                    <span
                        x-text="$wire.scientists"
                        class="input-group-text"
                    ></span>

                    <button
                        x-on:click="if ($wire.population > 0) {$wire.scientists++;$wire.population--}"
                        class="btn btn-outline-primary"
                    >+</button>

                    <label class="input-group-text">research</label>

                    <select
                        wire:model="chosenResearchId"
                        wire:loading.attr="disabled"
                        class="form-select"
                    >
                        <option value="0">Nothing</option>
                        @foreach($this->researches as $research)
                            <option wire:key="{{ $research->id }}" value="{{ $research->id }}">{{ $research->name }} | Progress: {{ $research->cityAsset->xp ?? 0 }} / {{ $research->xp }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        <div class="col-6">
            @if(Session::has('messages'))
                <ul>
                    @foreach(Session::get('messages') as $message)
                        <li>{{ $message }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

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