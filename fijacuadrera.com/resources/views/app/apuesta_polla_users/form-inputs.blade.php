@php $editing = isset($apuestaPollaUser) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="apuesta_polla_id" label="Apuesta Polla" required>
            @php $selected = old('apuesta_polla_id', ($editing ? $apuestaPollaUser->apuesta_polla_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Apuesta Polla</option>
            @foreach($apuestaPollas as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $apuestaPollaUser->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="caballo_id" label="Caballo" required>
            @php $selected = old('caballo_id', ($editing ? $apuestaPollaUser->caballo_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Caballo</option>
            @foreach($caballos as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="Resultadoapuesta"
            label="Resultadoapuesta"
            :value="old('Resultadoapuesta', ($editing ? $apuestaPollaUser->Resultadoapuesta : ''))"
            maxlength="255"
            placeholder="Resultadoapuesta"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
