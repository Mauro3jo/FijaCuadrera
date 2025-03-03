<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<head>
    <link rel="stylesheet" href="estilos.css">
</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight text-center">
            {{ __('Pantalla de Carreras') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Cambia la clase bg-white por bg-black -->
            <div class="bg-black overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Agrega este código para mostrar las carreras por fecha -->
                
                <div class="container-fluid">
                    <!-- Agrega este código para comprobar si hay carreras -->
                    @if ($carreras->isNotEmpty())
                        <h1 class="text-center">{{ $carreras->first()->first()->hipico->nombre }}</h1>
                        <ul class="list-group list-group-flush">
                            @foreach ($carreras as $fecha => $carreras_por_fecha)
                            <!-- Agrega el atributo style al elemento <li> que contiene la lista de carreras -->
                            <li class="list-group-item" style="background-color: black; color: white;">
                                <h3 class="text-center">{{ $fecha }}</h3>
                                <div class="card-group">
                                    @foreach ($carreras_por_fecha as $carrera)
                                    <!-- Agrega el atributo style al elemento <div> que contiene el card -->
                                    <div class="col-md-4 col-12" style="background-color: black; color: white;">
                                        <div class="card mb-4">
                                            <!-- Envuelve la imagen en un elemento <a> con la ruta adecuada -->
                                            @if ($carrera->imagen)
                                                @php
                                                // Obtén el número de caballos asociados a la carrera
                                                $num_caballos = $carrera->caballos()->count();
                                            @endphp   @php
                                                    // Obtén el número de caballos asociados a la carrera
                                                    $num_caballos = $carrera->caballos()->count();
                                                @endphp
                                                @if ($num_caballos > 2)
                                                    <a href="{{ route('carreras.apuestas.polla', $carrera->id) }}">
                                                        <img src="{{ asset('/' . $carrera->imagen) }}" class="card-img-top img-fluid" alt="{{ $carrera->nombre }}" width="150">
                                                    </a>
                                                @else
                                                    <a href="{{ route('carreras.apuestas.manomano', $carrera->id) }}">
                                                        <img src="{{ asset('/' . $carrera->imagen) }}" class="card-img-top img-fluid" alt="{{ $carrera->nombre }}" width="150">
                                                    </a>
                                                @endif
                                            @endif
                                            <!-- Envuelve el nombre de la carrera en un elemento <a> con la ruta adecuada -->
                                                <div class="card-header" style="background-color: black;">
                                                    @php
                                                        // Obtén el número de caballos asociados a la carrera
                                                        $num_caballos = $carrera->caballos()->count();
                                                    @endphp
                                                    @if ($num_caballos > 2)
                                                        <a href="{{ route('carreras.apuestas.polla', $carrera->id) }}">{{ $carrera->nombre }}</a>
                                                    @else
                                                        <a href="{{ route('carreras.apuestas.manomano', $carrera->id) }}">{{ $carrera->nombre }}</a>
                                                    @endif
                                                </div>
                                                
                                            <!-- Elimina el código que muestra el botón de apuestas -->
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    @else
                        <!-- Agrega este código para mostrar un mensaje cuando no hay carreras -->
                        <div class="alert alert-info" role="alert">
                            {{ __('No hay carreras disponibles') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>







