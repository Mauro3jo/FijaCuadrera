{{-- resources/views/historiales/create.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight" style="color: white;">
            {{ __('Crear Nuevo Historial') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('historiales.store') }}" class="mt-4">
                @csrf
                <!-- Campos del formulario -->
                <div class="mb-4">
                    <label for="semana" class="block font-medium text-white">Semana</label>
                    <input id="semana" type="text" name="semana" value="{{ old('semana') }}" required autofocus class="block mt-1 w-full" style="color: black;">
                </div>

                <div class="mb-4">
                    <label for="a_depositar" class="block font-medium text-white">A Depositar</label>
                    <input id="a_depositar" type="number" name="a_depositar" value="{{ old('a_depositar') }}" class="block mt-1 w-full" style="color: black;">
                </div>

                <div class="mb-4">
                    <label for="total_depositado" class="block font-medium text-white">Total Depositado</label>
                    <input id="total_depositado" type="number" name="total_depositado" value="{{ old('total_depositado') }}" class="block mt-1 w-full" style="color: black;">
                </div>

                <div class="mb-4">
                    <label for="saldo" class="block font-medium text-white">Saldo</label>
                    <input id="saldo" type="number" name="saldo" value="{{ old('saldo') }}" class="block mt-1 w-full" style="color: black;">
                </div>

                <div class="mb-4">
                    <label for="gano" class="block font-medium text-white">Ganó</label>
                    <input id="gano" type="number" name="gano" value="{{ old('gano') }}" class="block mt-1 w-full" style="color: black;">
                </div>

                <div class="mb-4">
                    <label for="perdio" class="block font-medium text-white">Perdió</label>
                    <input id="perdio" type="number" name="perdio" value="{{ old('perdio') }}" class="block mt-1 w-full" style="color: black;">
                </div>

                <div class="mb-4">
                    <label for="comision" class="block font-medium text-white">Comisión</label>
                    <input id="comision" type="number" name="comision" value="{{ old('comision') }}" class="block mt-1 w-full" style="color: black;">
                </div>

                <div class="mb-4">
                    <label for="SALDO_NEGATIVO" class="block font-medium text-white">Saldo Negativo</label>
                    <input id="SALDO_NEGATIVO" type="number" name="SALDO_NEGATIVO" value="{{ old('SALDO_NEGATIVO') }}" class="block mt-1 w-full" style="color: black;">
                </div>

                <div class="mb-4">
                    <label for="SALDO_POSITIVO" class="block font-medium text-white">Saldo Positivo</label>
                    <input id="SALDO_POSITIVO" type="number" name="SALDO_POSITIVO" value="{{ old('SALDO_POSITIVO') }}" class="block mt-1 w-full" style="color: black;">
                </div>

                <div class="mb-4">
                    <label for="SaldoAnterior" class="block font-medium text-white">Saldo Anterior</label>
                    <input id="SaldoAnterior" type="number" name="SaldoAnterior" value="{{ old('SaldoAnterior') }}" class="block mt-1 w-full" style="color: black;">
                </div>

                <div class="mb-4">
                    <label for="Diferencia" class="block font-medium text-white">Diferencia</label>
                    <input id="Diferencia" type="number" name="Diferencia" value="{{ old('Diferencia') }}" class="block mt-1 w-full" style="color: black;">
                </div>

                <div class="mb-4">
                    <label for="SaldoFinal" class="block font-medium text-white">Saldo Final</label>
                    <input id="SaldoFinal" type="number" name="SaldoFinal" value="{{ old('SaldoFinal') }}" class="block mt-1 w-full" style="color: black;">
                </div>

                <div class="mb-4">
                    <label for="OBSERVACION" class="block font-medium text-white">Observación</label>
                    <textarea id="OBSERVACION" name="OBSERVACION" class="block mt-1 w-full" style="color: black;">{{ old('OBSERVACION') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="INICIO" class="block font-medium text-white">Inicio</label>
                    <input id="INICIO" type="datetime-local" name="INICIO" value="{{ old('INICIO') }}" class="block mt-1 w-full" style="color: black;">
                </div>

                <div class="mb-4">
                    <label for="FIN" class="block font-medium text-white">Fin</label>
                    <input id="FIN" type="datetime-local" name="FIN" value="{{ old('FIN') }}" class="block mt-1 w-full" style="color: black;">
                </div>

                <div class="mb-4">
                    <label for="user_id" class="block font-medium text-white">Usuario</label>
                    <select id="user_id" name="user_id" class="block mt-1 w-full" style="color: black;">
                        <option value="">Seleccione un usuario</option>
                        @foreach($users as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-10">
                    <a href="{{ route('historiales.index') }}" class="button text-white">
                        {{ __('Cancelar') }}
                    </a>
                    <button type="submit" class="button button-primary float-right text-white">
                        {{ __('Guardar') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
