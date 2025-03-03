@php $editing = isset($hipico) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="nombre"
            label="Nombre"
            :value="old('nombre', ($editing ? $hipico->nombre : ''))"
            maxlength="255"
            placeholder="Nombre"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="direccion"
            label="Direccion"
            :value="old('direccion', ($editing ? $hipico->direccion : ''))"
            maxlength="255"
            placeholder="Direccion"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
<x-inputs.group class="w-full">
    <x-inputs.partials.label name="imagen" label="Imagen"></x-inputs.partials.label>
    
    <input type="file" name="imagen" id="imagen" class="form-control-file">
    
    @if($editing && $hipico->imagen)
        <div>
            <img src="{{ asset('storage/' . $hipico->imagen) }}" alt="">
        </div>
    @endif
</x-inputs.group>

