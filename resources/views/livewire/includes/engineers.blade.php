<div
    @if(! $this->workshopIsBuilt)
        data-bs-toggle="tooltip"
        data-bs-placement="right"
        title="To assign Engineers, you need to build Workshop."
    @endif
    class="input-group mb-3"
>
    <span class="input-group-text">Engineers</span>

    <button
            x-on:click="$wire.$js.decreaseRole('engineers')"
            @disabled(! $this->workshopIsBuilt)
            class="btn btn-outline-primary"
    >-</button>

    <span
            x-text="$wire.engineers"
            class="input-group-text"
    ></span>

    <button
            x-on:click="$wire.$js.increaseRole('engineers')"
            @disabled(! $this->workshopIsBuilt)
            class="btn btn-outline-primary"
    >+</button>

    <label class="input-group-text">develop</label>

    <select
            wire:model="chosenTechnologyId"
            wire:loading.attr="disabled"
            @disabled(! $this->workshopIsBuilt)
            class="form-select"
    >
        <option value="0">Nothing</option>
        @foreach($this->availableTechnologies as $technology)
            <option wire:key="{{ $technology->id }}" value="{{ $technology->id }}">{{ $technology->name }} | Progress: {{ $technology->colonyAsset->xp ?? 0 }} / {{ $technology->xp }}</option>
        @endforeach
    </select>
</div>
