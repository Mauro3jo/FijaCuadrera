<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nombre -->
        <div>
      
            <x-input-label for="name" :value="__('Nombre y Apellido')" class="text-white" />
      
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" style="background-color: black; color: white; border: 1px solid white;" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Correo electrónico -->
        <div class="mt-4">
   
            <x-input-label for="email" :value="__('Correo electrónico')" class="text-white" />
         
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" style="background-color: black; color: white; border: 1px solid white;" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>


        <!-- Celular -->
        <div class="mt-4">
        
            <x-input-label for="celular" :value="__('Celular')" class="text-white" />
      
            <x-text-input id="celular" class="block mt-1 w-full" type="text" name="celular" :value="old('celular')" required autocomplete="celular" style="background-color: black; color: white; border: 1px solid white;" />
            <x-input-error :messages="$errors->get('celular')" class="mt-2" />
        </div>

        <!-- DNI -->
        <div class="mt-4">
          
            <x-input-label for="dni" :value="__('DNI')" class="text-white" />
         
            <x-text-input id="dni" class="block mt-1 w-full" type="text" name="dni" :value="old('dni')" required autocomplete="dni" style="background-color: black; color: white; border: 1px solid white;" />
            <x-input-error :messages="$errors->get('dni')" class="mt-2" />
        </div>
        <div class="mt-4">
       
            <x-input-label for="password" :value="__('Contraseña')" class="text-white" />

         
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" style="background-color: black; color: white; border: 1px solid white;" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmar contraseña -->
        <div class="mt-4">

            <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" class="text-white" />

         
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" style="background-color: black; color: white; border: 1px solid white;" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        
        <div class="flex items-center justify-end mt-4">
         
            <a class="underline text-sm text-white hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('¿Ya estás registrado?') }}
            </a>

           
            <x-primary-button class="ml-4" style="background-color: green;">
                {{ __('Registrarse') }}
            </x-primary-button>
            
        </div>
    </form>
</x-guest-layout>


