<x-guest-layout>
    <!-- Enlace al archivo CSS -->
    <style>
        * {
          color: white;
        }

        .x-primary-button {
  background-color: green;
}

.btn {
  background-color: orange;
}

        .btn {
          display: inline-block;
          text-decoration: none;
        }

        .x-text-input {
          background-color: black;
        }

        .welcome-message {
          text-align: center;
          font-size: 24px;
          font-weight: bold;
          margin-bottom: 20px;
        }
    </style>

    <!-- Estado de la sesión -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Mensaje de bienvenida -->
        <div class="welcome-message">
            {{ __('Bienvenid@, ingresa tus datos para continuar') }}
        </div>

        <!-- Dirección de correo electrónico -->
        <div>
            <x-input-label for="email" :value="__('Correo electrónico')" class="text-white"/>
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" style="background-color: black; color: white; border: 1px solid white;" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Contraseña -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Contraseña')" class="text-white"/>

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            style="background-color: black; color: white; border: 1px solid white;"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Recuérdame -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600" style="color: white;">{{ __('Recuérdame') }} </span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}" style="color: white;">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif

            <x-primary-button class="ml-3" style="background-color: green;">
                {{ __('Iniciar sesión') }}
            </x-primary-button>

            <a href="{{ route('register') }}" class="btn ml-3 rounded-md bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                {{ __('Registrarse') }}
            </a>
        </div>
    </form>
</x-guest-layout>




