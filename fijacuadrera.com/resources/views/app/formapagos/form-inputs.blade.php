@php $editing = isset($formapago) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="cbu"
            label="Cbu"
            :value="old('cbu', ($editing ? $formapago->cbu : ''))"
            step="0.01"
            placeholder="Cbu"
            required
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="alias"
            label="Alias"
            :value="old('alias', ($editing ? $formapago->alias : ''))"
            maxlength="255"
            placeholder="Alias"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
