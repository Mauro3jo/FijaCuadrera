<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.apuestamanomano_users.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a
                        href="{{ route('apuestamanomano-users.index') }}"
                        class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.apuestamanomano_users.inputs.apuestamanomano_id')
                        </h5>
                        <span
                            >{{
                            optional($apuestamanomanoUser->apuestamanomano)->Caballo1
                            ?? '-' }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.apuestamanomano_users.inputs.user_id')
                        </h5>
                        <span
                            >{{ optional($apuestamanomanoUser->user)->name ??
                            '-' }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.apuestamanomano_users.inputs.caballo_id')
                        </h5>
                        <span
                            >{{ optional($apuestamanomanoUser->caballo)->nombre
                            ?? '-' }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.apuestamanomano_users.inputs.resultadoapuesta')
                        </h5>
                        <span
                            >{{ $apuestamanomanoUser->resultadoapuesta ?? '-'
                            }}</span
                        >
                    </div>
                </div>

                <div class="mt-10">
                    <a
                        href="{{ route('apuestamanomano-users.index') }}"
                        class="button"
                    >
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\ApuestamanomanoUser::class)
                    <a
                        href="{{ route('apuestamanomano-users.create') }}"
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
