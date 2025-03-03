
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<!-- CSS de Bootstrap -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
<!-- CSS de Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight text-center">
            {{ __('Pagina de Cargar Saldo') }}
        </h2>
        
    </x-slot>

    <div class="container mt-5" style="background-color: black;">
        <h3>Carga tu saldo aquí:</h3>
        @foreach($formapagos as $formapago)
          <div class="card mb-3" style="background-color: black;">
            <div class="card-body" style="background-color: black;">
              <h5 class="card-title">{{ $formapago->alias }}</h5>
              <p class="card-text">CBU: {{ $formapago->cbu }}</p>
            </div>
          </div>
        @endforeach
      </div>
      <div class="container mt-5" style="background-color: black;">
        <h3>Contacta con nosotros:</h3>
        @foreach($contactos as $contacto)
          <div class="card mb-3" style="background-color: black;">
            <div class="card-body" style="background-color: black;">
              <h5 class="card-title">{{ $contacto->HoraDisponible }}</h5>
              <p class="card-text">
                Celular: 
                <a href="https://wa.me/{{ $contacto->celular }}">
                  {{ $contacto->celular }}
                  <i class="bi bi-whatsapp"></i>
                </a>
              </p>
            </div>
          </div>
        @endforeach
      </div>
      
    <!-- ... -->

</x-app-layout>

