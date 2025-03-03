<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Listado de Usuarios Administrativos
        </h2>
        <head>
            <!-- Enlace al archivo jQuery -->
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        
            <!-- Enlace al archivo CSS de Bootstrap -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        
            <!-- Enlace al archivo JS de Bootstrap -->
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        
            <!-- Etiqueta meta con el token CSRF -->
            <meta name="csrf-token" content="{{ csrf_token() }}">
        </head>
        
    </x-slot>
  
    
    
    <div class="py-12 bg-black">
        <!-- Botones para cambiar entre las tablas -->
        <div class="mb-4">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mr-4"
                    onclick="showTable('usuarios')">Tabla Usuarios</button>
            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 mr-4"
                    onclick="showTable('ganadores')">Tabla Ganadores</button>
            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4"
                    onclick="showTable('perdedores')">Tabla Perdedores</button>
        </div>
    <div class="py-12 bg-black">
    
        <table id="tabla-ganadores" class="table-responsive table-bordered text-white border-collapse" style="display:none; width: 100%; border-color: white; margin: auto;">

            <thead>
                <tr>
                    <th style="text-align: center;">ID</th>
                    <th style="text-align: center;">Jugador</th>
                                        <th style="text-align: center;">Jugo</th>

                    <th style="text-align: center;">Gano</th>
                    <th style="text-align: center;">Perdio</th>
                    <th style="text-align: center;">Comision</th>
                    <th style="text-align: center;">Yo Transfiero:</th>
                    <th style="text-align: center;">Celular</th>
                    <th style="text-align: center;">CBU</th>
                    <th style="text-align: center;">Estado</th>
                    <th style="text-align: center;">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    @if (($user->Gano - ($user->Perdio + $user->Comision)) > 0)
                        <tr>
                            <td style="text-align: center;">{{ $user->id }}</td>
                            <td style="text-align: center;">{{ $user->name }}</td>
                             <td style="text-align: center;">{{ $user->Jugo }}</td>

                            <td style="text-align: center;">{{ $user->Gano }}</td>
                            <td style="text-align: center;">{{ $user->Perdio }}</td>
                            <td style="text-align: center;">{{ $user->Comision }}</td>
                            <td style="text-align: center;">{{$user->Gano - ($user->Perdio + $user->Comision) }}</td>

                            <td style="text-align: center;">{{ $user->celular }}</td>
                            <td style="text-align: center;">{{ $user->cbu }}</td>
                            <td style="text-align: center;">Debo</td>
                            <td style="text-align: center;">
                                <button class="btn btn-success" onclick="procesarDeuda({{ $user->id }}, 'pagar')">Pagar</button>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <table id="tabla-perdedores" class="table-responsive table-bordered text-white border-collapse" style="display:none; width: 100%; border-color: white; margin: auto;">
            <thead>
                <tr>
                    <th style="text-align: center;">ID</th>
                    <th style="text-align: center;">Jugador</th>
                                                            <th style="text-align: center;">Jugo</th>

                    <th style="text-align: center;">Gano</th>
                    <th style="text-align: center;">Perdio</th>
                    <th style="text-align: center;">Comision</th>
                    <th style="text-align: center;">Recibo Transferencia</th>
                    <th style="text-align: center;">Usuario</th>
                    <th style="text-align: center;">Celular</th>
                    <th style="text-align: center;">CBU</th>
                    <th style="text-align: center;">Estado</th>
                    <th style="text-align: center;">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    @if (($user->Gano - ($user->Perdio + $user->Comision)) < 0)
                        <tr>
                            <td style="text-align: center;">{{ $user->id }}</td>
                                                         <td style="text-align: center;">{{ $user->Jugo }}</td>

                            <td style="text-align: center;">{{ $user->Gano }}</td>
                            <td style="text-align: center;">{{ $user->Perdio }}</td>
                            <td style="text-align: center;">{{ $user->Comision }}</td>
                            <td style="text-align: center;">{{ $user->Gano - ($user->Perdio + $user->Comision) }}</td>

                            <td style="text-align: center;">{{ $user->celular }}</td>
                            <td style="text-align: center;">{{ $user->cbu }}</td>
                            <td style="text-align: center;">Falta</td>
                            <td style="text-align: center;">
                                <button class="btn btn-danger" onclick="procesarDeuda({{ $user->id }}, 'recibir')">Recibir</button>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        <table id="tabla-usuarios" class="table-responsive table-bordered text-white border-collapse" style="width: 100%; border-color: white; margin: auto;">
            <thead>
                <tr>
                    <th style="text-align: center;">ID</th>
                    <th style="text-align: center;">Jugador</th>
                                                            <th style="text-align: center;">Jugo</th>

                    <th style="text-align: center;">Gano</th>
                    <th style="text-align: center;">Perdio</th>
                    <th style="text-align: center;">Comision</th>
                    <th style="text-align: center;">Trasfiero</th>
                    <th style="text-align: center;">Celular</th>
                    <th style="text-align: center;">CBU</th>
                    <th style="text-align: center;">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td style="text-align: center;">{{ $user->id }}</td>
                            <td style="text-align: center;">{{ $user->name }}</td>
                                                         <td style="text-align: center;">{{ $user->Jugo }}</td>

                            <td style="text-align: center;">{{ $user->Gano }}</td>
                            <td style="text-align: center;">{{ $user->Perdio }}</td>
                            <td style="text-align: center;">{{ $user->Comision }}</td>
                            <td style="text-align: center;">{{ $user->Gano - ($user->Perdio + $user->Comision) }}</td>
                            <td style="text-align: center;">{{ $user->celular }}</td>
                            <td style="text-align: center;">{{ $user->cbu }}</td>
                            <td style="text-align: center;">{{ $user->Estado }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <script>
            function showTable(tabla) {
                // Oculta todas las tablas
                document.getElementById('tabla-usuarios').style.display = 'none';
                document.getElementById('tabla-ganadores').style.display = 'none';
                document.getElementById('tabla-perdedores').style.display = 'none';

                // Muestra la tabla seleccionada
                document.getElementById('tabla-' + tabla).style.display = 'table';
            }
          // Configura el encabezado X-CSRF-TOKEN con el valor del token CSRF
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function procesarDeuda(id, accion) {
    // Crea un objeto con los datos a enviar
    var data = {
        id: id,
        accion: accion
    };

    // Hace una petición AJAX a la ruta de Laravel
    $.ajax({
        url: '/procesar-deuda/' + id + '/' + accion,
        type: 'POST',
        data: data,
        success: function (response) {
            // Muestra un mensaje de éxito
            alert(response.success);
        },
        error: function (response) {
            // Muestra un mensaje de error
            alert(response.error);
        }
    });
}

        </script>
  
    </div>
</x-app-layout>
