@php $editing = isset($user) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            :value="old('name', ($editing ? $user->name : ''))"
            maxlength="255"
            placeholder="Name"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.email
            name="email"
            label="Email"
            :value="old('email', ($editing ? $user->email : ''))"
            maxlength="255"
            placeholder="Email"
            required
        ></x-inputs.email>
    </x-inputs.group>
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="password"
            label="password"
            :value="old('password', ($editing ? $user->password : ''))"
  
            placeholder="password"
            required
            ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.checkbox
            name="admin"
            label="Admin"
            :checked="old('admin', ($editing ? $user->admin : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="celular"
            label="Celular"
            :value="old('celular', ($editing ? $user->celular : ''))"
           
            step="0.01"
            placeholder="Celular"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="cbu"
            label="Cbu"
            :value="old('cbu', ($editing ? $user->cbu : ''))"
            step="0.01"
            placeholder="Cbu"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="alias"
            label="Alias"
            :value="old('alias', ($editing ? $user->alias : ''))"
            maxlength="255"
            placeholder="Alias"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="saldo"
            label="Saldo"
            :value="old('saldo', ($editing ? $user->saldo : '0'))"
            step="0.01"
            placeholder="Saldo"
        ></x-inputs.number>
    </x-inputs.group>
</div>
