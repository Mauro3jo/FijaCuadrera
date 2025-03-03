@php $editing = isset($apuestamanomano) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="carrera_id" label="Carrera" required>
            @php $selected = old('carrera_id', ($editing ? $apuestamanomano->carrera_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Carrera</option>
            @foreach($carreras as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="Ganancia"
            label="Ganancia"
            :value="old('Ganancia', ($editing ? $apuestamanomano->Ganancia : ''))"
            max="255"
            step="0.01"
            placeholder="Ganancia"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="Caballo1"
            label="Caballo1"
            :value="old('Caballo1', ($editing ? $apuestamanomano->Caballo1 : ''))"
            maxlength="255"
            placeholder="Caballo1"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="Caballo2"
            label="Caballo2"
            :value="old('Caballo2', ($editing ? $apuestamanomano->Caballo2 : ''))"
            maxlength="255"
            placeholder="Caballo2"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="Tipo"
            label="Tipo"
            :value="old('Tipo', ($editing ? $apuestamanomano->Tipo : ''))"
            maxlength="255"
            placeholder="Tipo"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.checkbox
            name="Estado"
            label="Estado"
            :checked="old('Estado', ($editing ? $apuestamanomano->Estado : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>
</div>
