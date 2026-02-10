<div class="input-group mb-3">
    <span class="input-group-text">Builders</span>

    <button
            x-on:click="$wire.$js.decreaseRole('builders')"
            class="btn btn-outline-primary"
    >-</button>

    <span
            x-text="$wire.builders"
            class="input-group-text"
    ></span>

    <button
            x-on:click="$wire.$js.increaseRole('builders')"
            class="btn btn-outline-primary"
    >+</button>

    <label class="input-group-text">build</label>

    <select
            wire:model="chosenBuildingId"
            wire:loading.attr="disabled"
            class="form-select"
    >
        <option value="0">Nothing</option>
        @foreach($this->availableBuildings as $building)
            <option wire:key="{{ $building->id }}" value="{{ $building->id }}">{{ $building->name }} | Progress: {{ $building->colonyAsset->xp ?? 0 }} / {{ $building->xp }}</option>
        @endforeach
    </select>
</div>