<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.apuesta_pollas.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('apuesta-pollas.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.apuesta_pollas.inputs.carrera_id')
                        </h5>
                        <span
                            >{{ optional($apuestaPolla->carrera)->nombre ?? '-'
                            }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.apuesta_pollas.inputs.Ganancia')
                        </h5>
                        <span>{{ $apuestaPolla->Ganancia ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.apuesta_pollas.inputs.Caballo1')
                        </h5>
                        <span>{{ $apuestaPolla->Caballo1 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.apuesta_pollas.inputs.Monto1')
                        </h5>
                        <span>{{ $apuestaPolla->Monto1 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.apuesta_pollas.inputs.Caballo2')
                        </h5>
                        <span>{{ $apuestaPolla->Caballo2 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.apuesta_pollas.inputs.Monto2')
                        </h5>
                        <span>{{ $apuestaPolla->Monto2 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.apuesta_pollas.inputs.Caballo3')
                        </h5>
                        <span>{{ $apuestaPolla->Caballo3 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.apuesta_pollas.inputs.Monto3')
                        </h5>
                        <span>{{ $apuestaPolla->Monto3 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.apuesta_pollas.inputs.Caballo4')
                        </h5>
                        <span>{{ $apuestaPolla->Caballo4 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.apuesta_pollas.inputs.Monto4')
                        </h5>
                        <span>{{ $apuestaPolla->Monto4 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.apuesta_pollas.inputs.Caballo5')
                        </h5>
                        <span>{{ $apuestaPolla->Caballo5 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.apuesta_pollas.inputs.Monto5')
                        </h5>
                        <span>{{ $apuestaPolla->Monto5 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.apuesta_pollas.inputs.Estado')
                        </h5>
                        <span>{{ $apuestaPolla->Estado ?? '-' }}</span>
                    </div>
                </div>

                <div class="mt-10">
                    <a
                        href="{{ route('apuesta-pollas.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\ApuestaPolla::class)
                    <a
                        href="{{ route('apuesta-pollas.create') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
