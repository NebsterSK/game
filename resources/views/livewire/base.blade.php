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

    <button wire:click="endTurn">End turn</button>
</div>
