<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historiales de Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <x-partials.card>
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2 text-right">
                            <a href="{{ route('historiales.create') }}" class="button button-primary">
                                <i class="mr-1 icon ion-md-add"></i>
                                {{ __('Crear Nuevo Historial') }}
                            </a>
                        </div>
                    </div>
                </div>
                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">{{ __('Usuario') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Semana') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('A Depositar') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Total Depositado') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Falta Depositar') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Ganó') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Perdió') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Comisión') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Saldo Negativo') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Saldo Positivo') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Saldo Anterior') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Diferencia') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Saldo Final') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Observación') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Inicio') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Fin') }}</th>
                                <th class="px-4 py-3 text-left">{{ __('Acciones') }}</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($historiales as $historial)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">{{ $historial->user->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $historial->semana ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $historial->a_depositar ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $historial->total_depositado ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $historial->saldo ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $historial->gano ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $historial->perdio ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $historial->comision ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $historial->SALDO_NEGATIVO ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $historial->SALDO_POSITIVO ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $historial->SaldoAnterior ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $historial->Diferencia ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $historial->SaldoFinal ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $historial->OBSERVACION ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $historial->INICIO ?? '-' }}</td>
                                <td class="px-4 py-3 text-left">{{ $historial->FIN ?? '-' }}</td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('historiales.show', $historial->id) }}" class="button button-small button-info">
                                        {{ __('Ver') }}
                                    </a>
                                    <a href="{{ route('historiales.edit', $historial->id) }}" class="button button-small button-warning">
                                        {{ __('Editar') }}
                                    </a>
                                    <form action="{{ route('historiales.destroy', $historial->id) }}" method="POST" onsubmit="return confirm('{{ __('¿Estás seguro que deseas eliminar este historial?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="button button-small button-danger">
                                            {{ __('Eliminar') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="17">
                                    {{ __('No hay historiales disponibles.') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
