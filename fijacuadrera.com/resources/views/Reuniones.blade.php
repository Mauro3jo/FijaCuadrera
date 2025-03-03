<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight text-center">
            {{ __('Pantalla de Reuniones') }}
  
      
       
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
            <!-- Cambia la clase bg-dark por bg-black -->
            <div class="bg-black overflow-hidden shadow-sm sm:rounded-lg">
            
                <div class="container">
                    <!-- Cambia la clase text-dark por text-white -->
                    <h1 class="text-center text-white">Reuniones</h1>
                      <div class="row justify-content-center">
                        @foreach ($hipicos as $hipico)
                
                        <div class="col-md-4 mx-auto">
                        
                            <!-- Cambia la clase bg-white por bg-black y agrega la clase text-white -->
                            <div class="card mb-4 bg-black text-white">
                           
                                <!-- Cambia el elemento img por un elemento a con el mismo href que el botón -->
                                <a href="{{ route('carreras.proximas', $hipico->id) }}" class="card-img-top img-fluid hover-zoom btn" role="button">
                                    <img src="{{ asset('/' . $hipico->imagen) }}" alt="{{ $hipico->nombre }}">
                                    
                                </a>

                                <div class="card-body">
                                    <h5 class="card-title">{{ $hipico->nombre }}</h5>
                                    <p class="card-text">{{ $hipico->descripcion }}</p>
                                    <!-- Cambia la clase btn-light por btn-success -->
                                    <a href="{{ route('carreras.proximas', $hipico->id) }}" class="btn btn-block btn-success">Ver próximas carreras</a>

                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    {{ $hipicos->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Agrega esta línea para incluir Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">

<!-- Agrega esta línea para incluir Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.bundle.min.js"></script>

<!-- Agrega esta línea para incluir Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
