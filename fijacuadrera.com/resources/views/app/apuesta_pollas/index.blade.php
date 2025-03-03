<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.apuesta_pollas.index_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-inputs.text
                                        name="search"
                                        value="{{ $search ?? '' }}"
                                        placeholder="{{ __('crud.common.search') }}"
                                        autocomplete="off"
                                    ></x-inputs.text>

                                    <div class="ml-1">
                                        <button
                                            type="submit"
                                            class="button button-primary"
                                        >
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="md:w-1/2 text-right">
                            @can('create', App\Models\ApuestaPolla::class)
                            <a
                                href="{{ route('apuesta-pollas.create') }}"
                                class="button button-primary"
                            >
                                <i class="mr-1 icon ion-md-add"></i>
                                @lang('crud.common.create')
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.apuesta_pollas.inputs.carrera_id')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.apuesta_pollas.inputs.Ganancia')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.apuesta_pollas.inputs.Caballo1')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.apuesta_pollas.inputs.Monto1')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.apuesta_pollas.inputs.Caballo2')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.apuesta_pollas.inputs.Monto2')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.apuesta_pollas.inputs.Caballo3')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.apuesta_pollas.inputs.Monto3')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.apuesta_pollas.inputs.Caballo4')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.apuesta_pollas.inputs.Monto4')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.apuesta_pollas.inputs.Caballo5')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.apuesta_pollas.inputs.Monto5')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.apuesta_pollas.inputs.Estado')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($apuestaPollas as $apuestaPolla)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ optional($apuestaPolla->carrera)->nombre
                                    ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $apuestaPolla->Ganancia ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $apuestaPolla->Caballo1 ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $apuestaPolla->Monto1 ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $apuestaPolla->Caballo2 ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $apuestaPolla->Monto2 ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $apuestaPolla->Caballo3 ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $apuestaPolla->Monto3 ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $apuestaPolla->Caballo4 ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $apuestaPolla->Monto4 ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $apuestaPolla->Caballo5 ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    {{ $apuestaPolla->Monto5 ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $apuestaPolla->Estado ?? '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center"
                                    style="width: 134px;"
                                >
                                    <div
                                        role="group"
                                        aria-label="Row Actions"
                                        class="
                                            relative
                                            inline-flex
                                            align-middle
                                        "
                                    >
                                        @can('update', $apuestaPolla)
                                        <a
                                            href="{{ route('apuesta-pollas.edit', $apuestaPolla) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i
                                                    class="icon ion-md-create"
                                                ></i>
                                            </button>
                                        </a>
                                        @endcan @can('view', $apuestaPolla)
                                        <a
                                            href="{{ route('apuesta-pollas.show', $apuestaPolla) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $apuestaPolla)
                                        <form
                                            action="{{ route('apuesta-pollas.destroy', $apuestaPolla) }}"
                                            method="POST"
                                            onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                        >
                                            @csrf @method('DELETE')
                                            <button
                                                type="submit"
                                                class="button"
                                            >
                                                <i
                                                    class="
                                                        icon
                                                        ion-md-trash
                                                        text-red-600
                                                    "
                                                ></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="14">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="14">
                                    <div class="mt-10 px-4">
                                        {!! $apuestaPollas->render() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
