@php $editing = isset($caballo) @endphp

<div class="flex flex-wrap">

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="nombre"
            label="Nombre"
            :value="old('nombre', ($editing ? $caballo->nombre : ''))"
            maxlength="255"
            placeholder="Nombre"
            required
        ></x-inputs.text>
    </x-inputs.group>

   

    
    
    
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="edad"
            label="Edad"
            :value="old('edad', ($editing ? $caballo->edad : ''))"
            max="255"
            step="0.01"
            placeholder="Edad"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="Raza"
            label="Propietario"
            :value="old('Raza', ($editing ? $caballo->Raza : ''))"
            maxlength="255"
            placeholder="Propietario"
            required
        ></x-inputs.text>
    </x-inputs.group>

  
    
</div>


