@php $editing = isset($contacto) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="celular"
            label="Celular"
            :value="old('celular', ($editing ? $contacto->celular : ''))"
        
            step="0.01"
            placeholder="Celular"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="HoraDisponible"
            label="Hora Disponible"
            :value="old('HoraDisponible', ($editing ? $contacto->HoraDisponible : ''))"
            maxlength="255"
            placeholder="Hora Disponible"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
