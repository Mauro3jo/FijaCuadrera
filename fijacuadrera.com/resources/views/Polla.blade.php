<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight text-center">
            {{ __('Pantalla de Pollas') }}
        </h2>
    </x-slot>
    <div class="container mx-auto py-8">
        <div class="card max-w-lg mx-auto">
            <div class="card-body" style="background-color: black;">
                <h1 class="card-title text-xl font-bold">{{ $carrera->nombre }}</h1>
                
                <!-- Mensaje de error -->
                <p id="error-message" class="text-danger" style="display:none;">Debe seleccionar al menos un caballo y asignar un monto a todos los campos.</p>

                <form action="{{ route('apuestaPolla.guardar', $carrera->id) }}" method="POST" id="form-apuesta">
                    @csrf
                    <div class="row row-cols-3 justify-content-center align-items-center mt-4">
                        @foreach ($caballos as $id => $nombre)
                            <div class="col p-2 text-center d-flex flex-column">
                                <label for="caballo-{{ $id }}">{{ $nombre }}</label>
                                <input type="checkbox" name="check[]" id="caballo-{{ $id }}" value="{{ $id }}">
                                <input type="hidden" name="caballos[]" id="caballo-{{ $id }}" value="{{ $id }}">
                                <input type="number" name="montos[]" id="monto-{{ $id }}" placeholder="$" min="0" style="background-color: white; color: black; border: 1px solid white;">
                            </div>
                        @endforeach
                    </div>
                    <div id="error-monto-saldo" class="text-danger" style="display:none;">El saldo es insuficiente para la suma de los montos seleccionados.</div>
                    <div class="d-flex justify-content-center mt-4">
                        <button type="button" class="btn btn-primary" id="btn-apostar" style="background-color: orange;">Enviar Polla</button>
                    </div>
                </form>

                <!-- Agrega este código después del formulario de apuestas -->
                <input type="hidden" name="caballo_id" id="caballo_id" value="">

                <!-- Agrega este código para mostrar la tabla de apuestas pollas -->
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Caballos</th>
                                <th>Estado</th>
                                <th>Montos</th>
                                <th>Jugar</th>
                                <th>Estado Final</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($apuestas_pollas as $apuesta_polla)
                                <tr>
                                    <td style="text-align: center; color: white; vertical-align: middle;">{{ $apuesta_polla->id }}</td>
                                    <td class="bordered-cell">
                                        @php $allGreenCaballos = true; @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($apuesta_polla->{"Caballo$i"} != 0)
                                                @php $hasBet = false; @endphp
                                                @foreach ($apuesta_polla->apuestaPollaUsers as $apuesta_polla_user)
                                                    @if ($apuesta_polla_user->caballo_id == $apuesta_polla->{"Caballo$i"})
                                                        @php $hasBet = true; @endphp
                                                    @endif
                                                @endforeach
                                                <span class="@if ($hasBet) verde @else rojo @endif">
                                                    <img src="{{ asset('/imagenes/Logo.jpeg') }}" alt="Caballo" style="width: 1em; height: 1em; display: inline-block; vertical-align: middle;">
                                                    <span style="display: inline-block; vertical-align: middle;">{{ $caballos[$apuesta_polla->{"Caballo$i"}] }}</span><br>
                                                </span>
                                                @if (!$hasBet) @php $allGreenCaballos = false; @endphp @endif
                                            @endif
                                        @endfor
                                    </td>
                                    <td class="divider">
                                        @php $allGreenCaballos = true; @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($apuesta_polla->{"Caballo$i"} != 0)
                                                @php $hasBet = false; @endphp
                                                @foreach ($apuesta_polla->apuestaPollaUsers as $apuesta_polla_user)
                                                    @if ($apuesta_polla_user->caballo_id == $apuesta_polla->{"Caballo$i"})
                                                        @php $hasBet = true; @endphp
                                                    @endif
                                                @endforeach
                                                <span class="@if ($hasBet) verde @else rojo @endif">@if ($hasBet) Están los @else Faltan los @endif</span><br>
                                                @if (!$hasBet) @php $allGreenCaballos = false; @endphp @endif
                                            @endif
                                        @endfor
                                    </td>
                                    <td class="divider">
                                        @php $allGreenMontos = true; @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($apuesta_polla->{"Caballo$i"} != 0)
                                                @php $hasBet = false; @endphp
                                                @foreach ($apuesta_polla->apuestaPollaUsers as $apuesta_polla_user)
                                                    @if ($apuesta_polla_user->caballo_id == $apuesta_polla->{"Caballo$i"})
                                                        @php $hasBet = true; @endphp
                                                    @endif
                                                @endforeach
                                                <span class="@if ($hasBet) verde @else rojo @endif">
                                                    @if ($hasBet) ${{ $apuesta_polla->{"Monto$i"} }} @else ($hasBet) ${{ $apuesta_polla->{"Monto$i"} }} @endif
                                                </span><br>
                                                @if (!$hasBet) @php $allGreenMontos = false; @endphp @endif
                                            @endif
                                        @endfor
                                    </td>
                                    <td class="divider">
                                        @php $allGreenMontos = true; @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($apuesta_polla->{"Caballo$i"} != 0)
                                                @php $hasBet = false; @endphp
                                                @foreach ($apuesta_polla->apuestaPollaUsers as $apuesta_polla_user)
                                                    @if ($apuesta_polla_user->caballo_id == $apuesta_polla->{"Caballo$i"})
                                                        @php $hasBet = true; @endphp
                                                    @endif
                                                @endforeach
                                                @if ($apuesta_polla->{"Monto$i"} > 0)
                                                    <center>
                                                        <span class="@if ($hasBet) verde @else rojo @endif">
                                                            @if ($hasBet) ✔ @else 
                                                                <!-- Agrega identificadores únicos al botón y a los inputs ocultos -->
                                                                <button class="boton-rojo pequeno-boton" id="boton-{{$apuesta_polla->id}}-{{$i}}" data-carrera-id="{{$apuesta_polla->carrera_id}}" data-apuesta-polla-id="{{$apuesta_polla->id}}" data-toggle="modal" data-target="#confirmarApuestaModal" data-caballo-id="{{ $apuesta_polla->{'Caballo' . $i} }}" data-monto="{{ $apuesta_polla->{'Monto' . $i} }}" data-apuesta-polla-id="{{ $apuesta_polla->id }}">Entrar</button>
                                                            @endif
                                                        </span>
                                                    </center><br>
                                                    @if (!$hasBet)
                                                        <!-- Inputs ocultos con identificadores únicos -->
                                                        <input type="hidden" id="apuesta-polla-id-{{$i}}" class="apuesta-polla-id" value="{{$apuesta_polla->id}}">
                                                        <input type="hidden" id="caballo-id-{{$i}}" class="caballo-id" value="{{ $apuesta_polla->{'Caballo' . $i} }}">
                                                        <input type="hidden" id="monto-{{$i}}" class="monto" value="{{ $apuesta_polla->{'Monto' . $i} }}">
                                                    @endif
                                                @endif
                                                @if (!$hasBet) @php $allGreenMontos = false; @endphp @endif
                                            @endif
                                        @endfor
                                    </td>
                                    <td style="text-align: center; color: white; vertical-align: middle;">
                                        @if ($apuesta_polla->Estado == 1)
                                            Cerrada
                                        @else
                                            Abierta
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Modal para saldo insuficiente -->
<div class="modal fade" id="verificarSaldoModal" tabindex="-1" role="dialog" aria-labelledby="verificarSaldoLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verificarSaldoLabel">Saldo Insuficiente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color: black;">
                <p>No tienes suficiente saldo para realizar esta apuesta.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: red;">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para confirmar la apuesta -->
<div class="modal fade" id="confirmarApuestaModal" tabindex="-1" role="dialog" aria-labelledby="confirmarApuestaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmarApuestaLabel">Confirmar Apuesta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color: black;">
                <p>¿Estás seguro de que quieres apostar <span id="montoApuesta"></span> por el caballo <span id="nombreCaballo"></span>?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" id="confirmarApuestaBtn" class="btn btn-primary">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById('form-apuesta');
    const btnApostar = document.getElementById('btn-apostar');
    const checkboxes = document.querySelectorAll('input[type=checkbox]');
    const montos = document.querySelectorAll('input[type=number]');
    const errorMessage = document.getElementById('error-message');
    const saldoDisponible = {{ auth()->user()->saldo }}; // Saldo disponible del usuario autenticado

    let selectedMonto = 0;
    let selectedCaballo = 0;
    let apuestaPollaId = 0;

    btnApostar.addEventListener('click', function() {
        let isValid = true;
        let checkboxChecked = false;
        let sumaMontos = 0;

        checkboxes.forEach((checkbox, index) => {
            if (checkbox.checked) {
                checkboxChecked = true;
                const monto = parseFloat(montos[index].value) || 0;
                sumaMontos += monto;
            }
        });

        montos.forEach((monto) => {
            if (monto.value === '' || parseFloat(monto.value) <= 0) {
                isValid = false;
            }
        });

        if (!checkboxChecked || !isValid) {
            errorMessage.style.display = 'block';
            return;
        }

        if (sumaMontos > saldoDisponible) {
            $('#verificarSaldoModal').modal('show');
            return;
        }

        form.submit();
    });

    $(document).ready(function() {
        // Abrir el modal de confirmación
        $('#confirmarApuestaModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            selectedMonto = button.data('monto');
            selectedCaballo = button.data('caballo-id');
            apuestaPollaId = button.data('apuesta-polla-id');

            var modal = $(this);
            modal.find('#montoApuesta').text('$' + selectedMonto);
            modal.find('#nombreCaballo').text(selectedCaballo);
        });

        // Confirmar la apuesta
        $('#confirmarApuestaBtn').on('click', function() {
            const carreraId = $('.boton-rojo').data('carrera-id');
            const csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'POST',
                url: '/carreras/' + carreraId + '/apuestas/polla/entrar',
                data: {
                    apuesta_polla_id: apuestaPollaId,
                    monto: selectedMonto,
                    caballoId: selectedCaballo,
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    console.log('Acción de entrar completada');
                    location.reload();
                },
                error: function(err) {
                    console.error('Error al realizar la acción de entrar', err);
                    alert('Error al realizar la apuesta. Inténtalo de nuevo más tarde.');
                }
            });
        });
    });
</script>

<style>
    /* Tu estilo actual */
    .card {
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        background-color: #ffffff;
    }

    /* Clase para la línea divisoria blanca */
    .divider {
        border-right: 1px solid white;
    }

    /* Clases para filas de colores según la apuesta */
    .apostado {
        background-color: black;
        color: white;
    }

    .verde {
        color: green;
    }

    .rojo {
        color: red;
    }

    /* Estilos para el botón */
    .boton-rojo {
        background-color: red;
        color: white;
        border: 1px solid red;
        border-radius: 4px;
        padding: 0.2em 0.5em;
        cursor: pointer;
        font-size: 1em; /* Ajuste del tamaño de fuente para que coincida con el texto */
        line-height: 1em; /* Alineación vertical */
        height: auto; /* Asegura que el botón no sea más alto que el texto */
    }

    /* Ajuste del tamaño del tilde */
    .verde span {
        font-size: 1em; /* Ajuste del tamaño de fuente para que coincida con el texto */
        line-height: 1em; /* Alineación vertical */
    }

    th {
        color: white;
    }

    .bordered-cell {
        border: 1px solid white; /* Establecer el borde blanco */
    }

    .pequeno-boton {
        padding: 0.2em 0.5em;
        font-size: 1em; /* Ajuste del tamaño de fuente para que coincida con el texto */
        line-height: 1em; /* Alineación vertical */
    }
    
    /* Añadimos estilos para que la tabla no sobresalga en móviles */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
</style>
