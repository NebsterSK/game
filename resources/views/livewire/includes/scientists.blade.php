<div
    @if(! $this->laboratoryIsBuilt)
        data-bs-toggle="tooltip"
        data-bs-placement="right"
        title="To assign Scientists, you need to build Laboratory."
    @endif
    class="input-group mb-3"
>
    <span class="input-group-text">Scientists</span>

    <button
            x-on:click="$wire.$js.decreaseRole('scientists')"
            @disabled(! $this->laboratoryIsBuilt)
            class="btn btn-outline-primary"
    >-</button>

    <span
            x-text="$wire.scientists"
            class="input-group-text"
    ></span>

    <button
            x-on:click="$wire.$js.increaseRole('scientists')"
            @disabled(! $this->laboratoryIsBuilt)
            class="btn btn-outline-primary"
    >+</button>

    <label class="input-group-text">research</label>

    <select
            wire:model="chosenResearchId"
            wire:loading.attr="disabled"
            @disabled(! $this->laboratoryIsBuilt)
            class="form-select"
    >
        <option value="0">Nothing</option>
        @foreach($this->availableResearches as $research)
            <option wire:key="{{ $research->id }}" value="{{ $research->id }}">{{ $research->name }} | Progress: {{ $research->colonyAsset->xp ?? 0 }} / {{ $research->xp }}</option>
        @endforeach
    </select>
</div>