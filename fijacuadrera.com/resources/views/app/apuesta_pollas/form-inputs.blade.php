@php $editing = isset($apuestaPolla) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="carrera_id" label="Carrera" required>
            @php $selected = old('carrera_id', ($editing ? $apuestaPolla->carrera_id : '')) @endphp
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
            :value="old('Ganancia', ($editing ? $apuestaPolla->Ganancia : ''))"
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
            :value="old('Caballo1', ($editing ? $apuestaPolla->Caballo1 : ''))"
            maxlength="255"
            placeholder="Caballo1"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="Monto1"
            label="Monto1"
            :value="old('Monto1', ($editing ? $apuestaPolla->Monto1 : ''))"
            max="255"
            step="0.01"
            placeholder="Monto1"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="Caballo2"
            label="Caballo2"
            :value="old('Caballo2', ($editing ? $apuestaPolla->Caballo2 : ''))"
            maxlength="255"
            placeholder="Caballo2"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="Monto2"
            label="Monto2"
            :value="old('Monto2', ($editing ? $apuestaPolla->Monto2 : ''))"
            max="255"
            step="0.01"
            placeholder="Monto2"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="Caballo3"
            label="Caballo3"
            :value="old('Caballo3', ($editing ? $apuestaPolla->Caballo3 : ''))"
            maxlength="255"
            placeholder="Caballo3"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="Monto3"
            label="Monto3"
            :value="old('Monto3', ($editing ? $apuestaPolla->Monto3 : ''))"
            max="255"
            step="0.01"
            placeholder="Monto3"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="Caballo4"
            label="Caballo4"
            :value="old('Caballo4', ($editing ? $apuestaPolla->Caballo4 : ''))"
            maxlength="255"
            placeholder="Caballo4"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="Monto4"
            label="Monto4"
            :value="old('Monto4', ($editing ? $apuestaPolla->Monto4 : ''))"
            max="255"
            step="0.01"
            placeholder="Monto4"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="Caballo5"
            label="Caballo5"
            :value="old('Caballo5', ($editing ? $apuestaPolla->Caballo5 : ''))"
            maxlength="255"
            placeholder="Caballo5"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="Monto5"
            label="Monto5"
            :value="old('Monto5', ($editing ? $apuestaPolla->Monto5 : ''))"
            max="255"
            step="0.01"
            placeholder="Monto5"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.checkbox
            name="Estado"
            label="Estado"
            :checked="old('Estado', ($editing ? $apuestaPolla->Estado : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>
</div>
