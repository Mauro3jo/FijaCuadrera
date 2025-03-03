@php $editing = isset($apuestamanomanoUser) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select
            name="apuestamanomano_id"
            label="Apuestamanomano"
            required
        >
            @php $selected = old('apuestamanomano_id', ($editing ? $apuestamanomanoUser->apuestamanomano_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Apuestamanomano</option>
            @foreach($apuestamanomanos as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $apuestamanomanoUser->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="caballo_id" label="Caballo" required>
            @php $selected = old('caballo_id', ($editing ? $apuestamanomanoUser->caballo_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Caballo</option>
            @foreach($caballos as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="resultadoapuesta"
            label="Resultadoapuesta"
            :value="old('resultadoapuesta', ($editing ? $apuestamanomanoUser->resultadoapuesta : ''))"
            maxlength="255"
            placeholder="Resultadoapuesta"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
