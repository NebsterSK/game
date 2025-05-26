<div>
    <h1>{{ $this->city->name }}</h1>

    <p>Turn: {{ $this->city->turn }}</p>

    <hr>

{{--    <div>--}}
{{--        @foreach($messages as $message)--}}
{{--            <p>{{ $message }}</p>--}}
{{--        @endforeach--}}
{{--    </div>--}}

    <hr>

    <p>
        Builders

        <button x-on:click="$wire.builders--">-</button>
        <input wire:model="builders" type="number" disabled />
        <button x-on:click="$wire.builders++">+</button>

        <select>
            <option value="">Housing</option>
            <option value="">Workshop</option>
            <option value="">Laboratory</option>
            <option value="">Headquarters</option>
            <option value="">Warehouse</option>
        </select>
    </p>

    <p>
        Engineers

        <button x-on:click="$wire.engineers--">-</button>
        <input wire:model="engineers" type="number" disabled />
        <button x-on:click="$wire.engineers++">+</button>

        <select>
            <option value="">Solar panels</option>
            <option value="">Antena</option>
            <option value="">Telescope</option>
            <option value="">Rover</option>
        </select>
    </p>

    <p>
        Scientists

        <button x-on:click="$wire.scientists--">-</button>
        <input wire:model="scientists" type="number" disabled />
        <button x-on:click="$wire.scientists++">+</button>

        <select>
            <option value="">Soil samples</option>
            <option value="">Atmosphere composition</option>
        </select>
    </p>

    <hr>

    <button wire:click="endTurn">End turn</button>
</div>
