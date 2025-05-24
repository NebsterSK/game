<div>
    <div>
        @foreach($messages as $message)
            <p>{{ $message }}</p>
        @endforeach
    </div>

    <p>
        Builders

        <button x-on:click="$wire.builders--">-</button>
        <input wire:model="builders" type="number" disabled />
        <button x-on:click="$wire.builders++">+</button>

        <select>
            <option value=""></option>
        </select>
    </p>

    <p>
        Engineers

        <button x-on:click="$wire.engineers--">-</button>
        <input wire:model="engineers" type="number" disabled />
        <button x-on:click="$wire.engineers++">+</button>

        <select>
            <option value=""></option>
        </select>
    </p>

    <p>
        Scientists

        <button x-on:click="$wire.scientists--">-</button>
        <input wire:model="scientists" type="number" disabled />
        <button x-on:click="$wire.scientists++">+</button>

        <select>
            <option value=""></option>
        </select>
    </p>

    <button wire:click="endTurn">End turn</button>
</div>
