<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight text-center">
            {{ __('Salones') }}
        </h2>
    </x-slot>

    <ul class="nav nav-tabs" id="myTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="manoAMano-tab" data-toggle="tab" href="#manoAMano" role="tab" aria-controls="manoAMano" aria-selected="true" style="background-color: red; color: white;">Mano a Mano</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pollas-tab" data-toggle="tab" href="#pollas" role="tab" aria-controls="pollas" aria-selected="false" style="background-color: green; color: white;">Pollas</a>
        </li>
    </ul>

    <div class="tab-content" id="myTabsContent">
        <div class="tab-pane fade show active" id="manoAMano" role="tabpanel" aria-labelledby="manoAMano-tab">
            <table class="table table-striped table-responsive">
                <thead>
                    <tr>
                        <th style="color: white;">N°</th>
                        <th style="color: white;">Carrera</th>
                        <th style="color: white;">Modo</th>
                        <th style="color: white;">Caballo</th>
                        <th style="color: white;">Apuesta</th>
                        <th style="color: white;">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apuestasManoMano as $apuesta)
                        <tr>
                            @php
                                $color = ($apuesta->apuestamanomano->Tipo == 'pago') ? 'red' : (($apuesta->apuestamanomano->Tipo == 'doy') ? 'green' : 'orange');
                                $modalId = "confirmar-modal-" . $apuesta->id;
                            @endphp
                            <td style="color: {{ $color }};">{{ $apuesta->apuestamanomano->id }}</td>
                            <td style="color: {{ $color }};">{{ $apuesta->apuestamanomano->carrera->nombre }}</td>
                            <td style="color: {{ $color }};">{{ ($apuesta->apuestamanomano->Tipo == 'pago') ? 'Pago Derecho a' : (($apuesta->apuestamanomano->Tipo == 'doy') ? 'Doy con' : 'Recibo con') }}</td>
                            <td style="color: {{ $color }};">
                                <img src="{{ asset('/imagenes/Logo.jpeg') }}" alt="Caballo" style="width: 1em; height: 1em; display: inline-block; vertical-align: middle;">
                                <span style="display: inline-block; vertical-align: middle;">{{ $apuesta->caballo->nombre }}</span>
                            </td>
                            <td style="color: {{ $color }};">
                                @if ($apuesta->apuestamanomano->Tipo == 'pago')
                                    @if($apuesta->caballo->nombre == $apuesta->apuestamanomano->Caballo1)
                                        $ {{ $apuesta->apuestamanomano->Monto1 }}
                                    @else
                                        $ {{ $apuesta->apuestamanomano->Monto1 }}
                                    @endif
                                @else
                                    @if($apuesta->caballo->nombre == $apuesta->apuestamanomano->Caballo1)
                                        $ {{ $apuesta->apuestamanomano->Monto1 }}
                                    @else
                                        $  {{ $apuesta->apuestamanomano->Monto2 }}
                                    @endif
                                    @if ($apuesta->apuestamanomano->Tipo == 'pago')
                                        Y
                                    @else
                                        A
                                    @endif
                                    @if($apuesta->caballo->nombre == $apuesta->apuestamanomano->Caballo1)
                                        ${{ $apuesta->apuestamanomano->Monto2 }}
                                    @else
                                        ${{ $apuesta->apuestamanomano->Monto1 }}
                                    @endif
                                @endif
                            </td>
                            @if ($apuesta->apuestamanomano->Estado == 1)
                                <td style="color: {{ $color }};">Jugada</td>
                            @else
                                <td>
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#{{ $modalId }}" style="margin: 0 auto; background-color: {{ $color }};">
                                        Aceptar apuesta
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade" id="{{ $modalId }}" tabindex="-1" role="dialog" aria-labelledby="confirmarLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmarLabel">Confirmar apuesta</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <span id="apuesta-id-{{ $apuesta->id }}" data-apuestamanomano-id="{{ $apuesta->apuestamanomano->id }}"></span>
                                                    <span id="monto2-{{ $apuesta->id }}" data-monto2="{{ $apuesta->apuestamanomano->Monto2 }}"></span>
                                                    <span id="caballo2-{{ $apuesta->id }}" data-caballo2="{{ $apuesta->apuestamanomano->Caballo2 }}"></span>
                                                    <span id="carrera-id-{{ $apuesta->id }}" data-carrera-id="{{ $apuesta->apuestamanomano->carrera->id }}"></span>
                                                    <p>¿Estás seguro de que quieres aceptar esta apuesta?</p>
                                                    <p>Estás apostando ${{ $apuesta->apuestamanomano->Monto2 }} en {{ $apuesta->apuestamanomano->Caballo2 }}.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal" style="background-color: red;">Cancelar</button>
                                                    <button type='submit' id="confirmar-apuesta-{{ $apuesta->id }}" data-url="{{ route('carreras.apuestas.aceptar', ['id' =>  $apuesta->apuestamanomano->carrera->id]) }}" class='btn btn-primary' style="margin: 0 auto; background-color: green;" data-apuesta-id="{{ $apuesta->id }}">Confirmar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="pollas" role="tabpanel" aria-labelledby="pollas-tab">
            <table class="table table-bordered table-responsive">
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
                    @foreach ($apuestasPolla as $apuesta_polla)
                        <tr>
                            <td style="text-align: center; color: white; vertical-align: middle;">{{ $apuesta_polla->id }}</td>
                            <td class="bordered-cell">
                                @php $allGreenCaballos = true; @endphp
                                @for ($i = 1; $i <= 5; $i++)
                                    @php
                                        $caballoId = $apuesta_polla->{"Caballo$i"};
                                        $caballo = \App\Models\Caballo::find($caballoId);
                                    @endphp
                                    @if ($caballoId != 0 && $caballo)
                                        @php $hasBet = false; @endphp
                                        @foreach ($apuesta_polla->apuestaPollaUsers as $apuesta_polla_user)
                                            @if ($apuesta_polla_user->caballo_id == $caballoId)
                                                @php $hasBet = true; @endphp
                                            @endif
                                        @endforeach
                                        <span class="@if ($hasBet) verde @else rojo @endif">
                                            <img src="{{ asset('/imagenes/Logo.jpeg') }}" alt="Caballo" style="width: 1em; height: 1em; display: inline-block; vertical-align: middle;">
                                            <span style="display: inline-block; vertical-align: middle;">{{ $caballo->nombre }}</span><br>
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
                                            <span class="@if ($hasBet) verde @else rojo @endif">
                                                @if ($hasBet) ✔ @else 
                                                    <button class="boton-rojo pequeno-boton" id="boton-{{$apuesta_polla->id}}-{{$i}}" data-carrera-id="{{$apuesta_polla->carrera_id}}" data-apuesta-polla-id="{{$apuesta_polla->id}}" data-toggle="modal" data-target="#confirmarApuestaModal" data-caballo-id="{{ $apuesta_polla->{'Caballo' . $i} }}" data-monto="{{ $apuesta_polla->{'Monto' . $i} }}" data-apuesta-polla-id="{{ $apuesta_polla->id }}">Entrar</button>
                                                @endif
                                            </span><br>
                                            @if (!$hasBet)
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
                                @if ($apuesta_polla->estado == 1)
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
    $(document).ready(function() {
        // Activa las pestañas de Bootstrap
        $('#myTabs a').on('click', function(e) {
            e.preventDefault()
            $(this).tab('show')
        });

        // Evento click para todos los botones que comienzan con 'confirmar-apuesta'
        $('[id^=confirmar-apuesta]').on('click', function(e) {
            e.preventDefault();

            var id = $(this).data('apuesta-id'); // Obtener el id de la apuesta
            var apuesta_id = $('#apuesta-id-' + id).data('apuestamanomano-id'); // Obtener el elemento span y leer su atributo de datos
            var monto2 = $('#monto2-' + id).data('monto2'); // Obtener el elemento span y leer su atributo de datos
            var caballo2 = $('#caballo2-' + id).data('caballo2'); // Obtener el elemento span y leer su atributo de datos
            var carrera_id = $('#carrera-id-' + id).data('carrera-id'); // Obtener el elemento span y leer su atributo de datos

            var data = new FormData(); // Crear un objeto FormData
            data.append('_token', $('meta[name="csrf-token"]').attr('content')); // Añadir el token CSRF
            data.append('apuestamanomano_id', apuesta_id); // Añadir el id de la apuesta
            data.append('monto2', monto2); // Añadir el monto2
            data.append('caballo2', caballo2); // Añadir el caballo2
            data.append('carrera_id', carrera_id); // Añadir el id de la carrera

            $.ajax({
                url: $(this).data('url'), // Leer el atributo de datos
                type: 'POST',
                data: data,
                processData: false, // Evitar que jQuery procese los datos
                contentType: false, // Evitar que jQuery establezca el tipo de contenido
                success: function(response) {
                    // Manejar la respuesta del servidor
                    console.log(response);
                    // Si la respuesta es exitosa, recargar la página
                    if (response.success) {
                        // Crear el mensaje de éxito
                        var mensaje = '<div class="alert alert-success">Apuesta aceptada correctamente</div>';
                        // Mostrar el mensaje de éxito en la vista
                        $('#mensaje').append(mensaje);
                        // Recargar la página después de 1 segundo
                        setTimeout(function() {
                            location.reload();
                        }, 1000); // 1000 milisegundos = 1 segundo
                    } else {
                        var mensaje = '<div class="alert alert-danger">No tiene saldo suficiente para hacer la apuesta</div>';
                        // Mostrar el mensaje de error en la vista
                        $('#mensaje').html(mensaje);
                        setTimeout(function() {
                            location.reload();
                        }, 1000); // 1000 milisegundos = 1 segundo
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Manejar el error de la solicitud
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        });

        // Captura el clic del botón de "Entrar" dentro de la tabla de apuestas pollas
        $('.boton-rojo').on('click', function() {
            // Obtiene el ID de la carrera y otros datos del botón que se ha hecho clic
            var carreraId = $(this).data('carrera-id');
            var apuestaPollaId = $(this).data('apuesta-polla-id');
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            
            // Obtiene el ID del botón para identificar los inputs ocultos correspondientes
            var botonId = $(this).attr('id').split('-')[2];
            
            // Usa el ID del botón para encontrar los inputs ocultos correctos
            var monto = $('#monto-' + botonId).val();
            var caballoId = $('#caballo-id-' + botonId).val();

            // Envía la solicitud POST al controlador para la acción de "entrar"
            $.ajax({
                type: 'POST',
                url: '/carreras/' + carreraId + '/apuestas/polla/entrar',
                data: {
                    apuesta_polla_id: apuestaPollaId,
                    monto: monto,
                    caballoId: caballoId, // Asegúrate de que el nombre del campo coincida con lo que espera tu servidor
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

        // Abrir el modal de confirmación para las apuestas pollas
        $('#confirmarApuestaModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var monto = button.data('monto');
            var caballoId = button.data('caballo-id');
            var apuestaPollaId = button.data('apuesta-polla-id');

            var modal = $(this);
            modal.find('#montoApuesta').text('$' + monto);
            modal.find('#nombreCaballo').text(caballoId);

            $('#confirmarApuestaBtn').off('click').on('click', function() {
                $.ajax({
                    type: 'POST',
                    url: '/carreras/' + carreraId + '/apuestas/polla/entrar',
                    data: {
                        apuesta_polla_id: apuestaPollaId,
                        monto: monto,
                        caballoId: caballoId,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
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
    });
</script>

<style>
    .btn-success {
        background-color: green;
        border-color: green;
    }

    .card {
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        background-color: #ffffff;
    }

    .divider {
        border-right: 1px solid white;
    }

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

    .boton-rojo {
        background-color: red;
        color: white;
        border: 1px solid red;
        border-radius: 4px;
        padding: 0.2em 0.5em;
        cursor: pointer;
        font-size: 0.8em;
    }

    th {
        color: white;
    }

    .bordered-cell {
        border: 1px solid white;
    }

    .pequeno-boton {
        padding: 0.2em 0.5em;
        font-size: 0.8em;
    }
</style>
