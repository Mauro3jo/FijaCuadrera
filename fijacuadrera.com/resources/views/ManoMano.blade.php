<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pantalla de Apuestas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <x-app-layout>
        <x-slot name="header">
            <div class="container">
                <h2 class="font-semibold text-xl text-white-800 leading-tight text-center">
                    {{ __('Pantalla de Apuestas') }}
                </h2>
            </div>
        </x-slot>

        <div class="container">
            <div class="row">
                <div class="col" align="center" style="background-color: black;">
                    <h1>Segui los pasos y juga!!!</h1>
                    <h4>Saldo para jugar: ${{ auth()->user()->saldo }}</h4>
                    <div class="card" style="background-color: black;">
                        <div class="card-body" style="background-color: black;">
                            <h5 class="card-title">1° Paso Elegir Caballo</h5>
                            <p id="error-caballo" class="text-danger" style="display:none;">Debe seleccionar un caballo.</p>
                            <div class="form-group" id="tipo-group" style="background-color: black;">
                                <form action="{{ route('carreras.apuestas.guardar', ['id' => $carrera->id]) }}" method="POST">
                                    @csrf
                                    <div class="form-group" style="background-color: black;">
                                        @php
                                            $i = 0;
                                            $n = count($caballos);
                                        @endphp
                                        @foreach ($caballos as $id => $nombre)
                                            <button type="button" class="btn btn-primary" id="btn-{{ $id }}" data-id="{{ $id }}" name="caballo1" value="{{ $id }}" style="margin: 0 auto; background-color: #0000ff;">{{ $nombre }}</button>
                                            @php
                                                $i++;
                                            @endphp
                                            @if ($i < $n)
                                                <label for="">vs</label>
                                            @endif
                                        @endforeach
                                    </div>
                                    <h5 class="card-title">2° Paso Elegir un Modo</h5>
                                    <p id="error-tipo" class="text-danger" style="display:none;">Debe seleccionar un modo.</p>
                                    <button type="button" class="btn btn-secondary" id="btn-pago" name="tipo" value="pago" style="margin: 0 auto; background-color: red;">Pago derecho a</button>
                                    <button type="button" class="btn btn-secondary" id="btn-doy" name="tipo" value="doy" style="margin: 0 auto; background-color: green;">Doy con</button>
                                    <button type="button" class="btn btn-secondary" id="btn-recibo" name="tipo" value="recibo" style="margin: 0 auto; background-color: orange;">Recibo con</button>
                                </div>
                                <div class="form-group" id="monto-group" style="background-color: black;">
                                    <h5>3° Paso ¿Cuanto Quieres Jugar?</h5>
                                    <p id="error-monto" class="text-danger" style="display:none;">Debe ingresar ambos montos.</p><br>
                                    <label for="inputMonto1">Monto $</label>
                                    <input id="inputMonto1" type="number" class="form-control d-inline-block w-auto mr-2" name="inputMonto1" style="margin: 0 auto;">
                                    <label for="inputMonto2">Monto $</label>
                                    <input id="inputMonto2" type="number" class="form-control d-inline-block w-auto ml-2" name="inputMonto2" style="margin: 0 auto;">
                                </div>
                                <h3>4° Paso Enviar Desafio</h3><br>
                                <p id="mensaje"></p>
                                <div class="form-group" style="background-color: black;">
                                    <button type='button' id='enviar-apuesta' data-url="{{ route('carreras.apuestas.guardar', ['id' => $carrera->id]) }}" data-carrera-id="{{ $carrera->id }}" class='btn btn-success' style="margin: 0 auto;">Enviar Desafio</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="text-center">SALON DE APUESTAS</h3>
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
                    @foreach ($apuestas as $apuesta)
                        <tr>
                            @php
                                $color = ($apuesta->apuestamanomano->Tipo == 'pago') ? 'red' : (($apuesta->apuestamanomano->Tipo == 'doy') ? 'green' : 'orange');
                                $modalId = "confirmar-modal-" . $apuesta->id;
                            @endphp

                            <td style="color: {{ $color }};">{{ $apuesta->apuestamanomano->id }}</td>
                            <td style="color: {{ $color }};">{{$carrera->nombre}}</td> <!-- Modificado para mostrar el nombre de la carrera -->
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
                                                <div class="modal-body" style="color: black;">
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
    </x-app-layout>

    <!-- Modal para verificar saldo insuficiente -->
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

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        var btnsCaballos = document.querySelectorAll('.btn-primary');
        var btnPago = document.getElementById('btn-pago');
        var btnDoy = document.getElementById('btn-doy');
        var btnRecibo = document.getElementById('btn-recibo');
        var tipoGroup = document.getElementById('tipo-group');
        var montoGroup = document.getElementById('monto-group');
        var inputMonto1 = document.getElementById('inputMonto1');
        var inputMonto2 = document.getElementById('inputMonto2');
        var mensaje = document.getElementById('mensaje');
        var saldoDisponible = {{ auth()->user()->saldo }}; // Saldo disponible del usuario autenticado

        $(document).ready(function() {
            $('#myTabs a').on('click', function (e) {
                e.preventDefault()
                $(this).tab('show')
            })

            $('[id^=confirmar-apuesta]').on('click', function(e) {
                e.preventDefault();

                var id = $(this).data('apuesta-id');
                var apuesta_id = $('#apuesta-id-' + id).data('apuestamanomano-id');
                var monto2 = $('#monto2-' + id).data('monto2');
                var caballo2 = $('#caballo2-' + id).data('caballo2');
                var carrera_id = $('#carrera-id-' + id).data('carrera-id');

                var data = new FormData();
                data.append('_token', $('meta[name="csrf-token"]').attr('content'));
                data.append('apuestamanomano_id', apuesta_id);
                data.append('monto2', monto2);
                data.append('caballo2', caballo2);
                data.append('carrera_id', carrera_id);

                $.ajax({
                    url: $(this).data('url'),
                    type: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        if (response.success) {
                            var mensaje = '<div class="alert alert-success">Apuesta aceptada correctamente</div>';
                            $('#mensaje').append(mensaje);
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            var mensaje = '<div class="alert alert-danger">No tiene saldo suficiente para hacer la apuesta</div>';
                            $('#mensaje').html(mensaje);
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                    }
                });
            });

            $('#enviar-apuesta').on('click', function(e) {
                e.preventDefault();

                var caballo1 = $('.btn-primary.active').val();
                var caballo2 = $('.btn-primary').not('.active').val();
                var tipo = $('.btn-secondary.active').val();
                var carrera_id = $('#enviar-apuesta').data('carrera-id');
                var monto1 = $('#inputMonto1').val();
                var monto2 = $('#inputMonto2').val();

                if (!caballo1 || !tipo || !monto1 || (!monto2 && tipo !== 'pago')) {
                    if (!caballo1) {
                        $('#error-caballo').show();
                    } else {
                        $('#error-caballo').hide();
                    }
                    if (!tipo) {
                        $('#error-tipo').show();
                    } else {
                        $('#error-tipo').hide();
                    }
                    if (!monto1 || (!monto2 && tipo !== 'pago')) {
                        $('#error-monto').show();
                    } else {
                        $('#error-monto').hide();
                    }
                    return;
                }

                var montoApuesta = tipo === 'pago' ? parseFloat(monto1) : parseFloat(monto1) + parseFloat(monto2);

                if (montoApuesta > saldoDisponible) {
                    $('#montoApuesta').text('$' + montoApuesta);
                    $('#caballoSeleccionado').text($('#btn-' + caballo1).text());
                    $('#mensajeSaldoInsuficiente').show();
                    $('#verificarSaldoModal').modal('show');
                    return;
                } 

                // Lógica para enviar la apuesta si el saldo es suficiente
                var data = {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    carrera_id: carrera_id,
                    tipo: tipo,
                    monto1: monto1,
                    monto2: monto2,
                    caballo1: caballo1,
                    caballo2: caballo2
                };

                $.ajax({
                    url: $(this).data('url'),
                    type: 'POST',
                    data: data,
                    success: function(response) {
                        if (response.success) {
                            var mensaje = '<div class="alert alert-success">Apuesta guardada correctamente</div>';
                            $('#mensaje').append(mensaje);
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            alert(response.error);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                    }
                });
            });

            function actualizarMensaje() {
                var btnCaballoActivo = document.querySelector('.btn-primary.active');
                var btnTipoActivo = document.querySelector('.btn-secondary.active');
                var monto1 = inputMonto1.value;
                var monto2 = inputMonto2.value;
                var texto = '';

                if (btnTipoActivo) {
                    texto += ' ' + btnTipoActivo.textContent;
                }

                if (btnCaballoActivo) {
                    texto += ' ' + btnCaballoActivo.textContent;
                }

                if (monto1) {
                    texto += ' ' + monto1;
                }

                if (btnTipoActivo && btnTipoActivo.value == "pago") {
                    if (monto2) {
                        texto += ' y ' + monto2;
                    }
                } else {
                    if (monto2) {
                        texto += ' a ' + monto2;
                    }
                }

                mensaje.textContent = texto;
            }

            btnsCaballos.forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var id = this.dataset.id;
                    var btnCaballoActivo = document.querySelector('.btn-primary.active');

                    if (!btnCaballoActivo || btnCaballoActivo.dataset.id !== id) {
                        if (btnCaballoActivo) {
                            btnCaballoActivo.classList.remove('active');
                        }

                        this.classList.add('active');
                        actualizarMensaje();
                    }
                });
            });

            btnPago.addEventListener('click', function() {
                var btnTipoActivo = document.querySelector('.btn-secondary.active');

                if (!btnTipoActivo || btnTipoActivo.id !== this.id) {
                    if (btnTipoActivo) {
                        btnTipoActivo.classList.remove('active');
                    }

                    this.classList.add('active');
                    document.getElementById('inputMonto1').hidden = false; 
                    document.getElementById('inputMonto2').hidden = true; 
                    actualizarMensaje();
                }
            });

            [btnDoy, btnRecibo].forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var btnTipoActivo = document.querySelector('.btn-secondary.active');

                    if (!btnTipoActivo || btnTipoActivo.id !== this.id) {
                        if (btnTipoActivo) {
                            btnTipoActivo.classList.remove('active');
                        }

                        this.classList.add('active');
                        document.getElementById('inputMonto1').hidden = false; 
                        document.getElementById('inputMonto2').hidden = false; 
                        actualizarMensaje();
                    }
                });
            });

            [inputMonto1, inputMonto2].forEach(function(input) {
                input.addEventListener('input', function() {
                    actualizarMensaje();
                });
            });
        });
    </script>

    <style>
        .btn-success {
            background-color: green;
            border-color: green;
        }
    </style>
</body>
</html>
