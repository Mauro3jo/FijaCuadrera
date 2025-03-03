<x-app-layout>
    <x-slot name="header">
        <!-- Encabezado de la página, si es necesario -->
    </x-slot>
    <style>
        .tabla-apuestas {
            width: 100%;
            border-collapse: collapse;
            margin: auto;
        }

        .tabla-apuestas th, .tabla-apuestas td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        .tabla-apuestas th {
            background-color: #000000;
        }
    </style>

    <!-- Botones para cambiar entre tablas -->
    <div style="text-align: center; margin-bottom: 20px;">
        <button onclick="document.getElementById('tabla1').style.display='block';document.getElementById('tabla2').style.display='none';" style="background-color: green; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-right: 10px;">Mano Mano</button>
        <button onclick="document.getElementById('tabla1').style.display='none';document.getElementById('tabla2').style.display='block';" style="background-color: red; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Pollas</button>
    </div>

    <!-- Tabla de Apuestas -->
    <div id="tabla1" style="display:block;">
        <!-- Filtro de búsqueda -->
        <label for="filtroResultado">Filtrar por Resultado de Apuesta:</label>
        <select id="filtroResultado" onchange="filtrarApuestas()" style="background-color: black; color: white;"></select>

        <script>
        // Función para inicializar el filtro con valores únicos de la columna de resultados
        function inicializarFiltro() {
            var table, tr, td, i, resultado, resultadosUnicos = {};
            table = document.getElementById("tabla1");
            tr = table.getElementsByTagName("tr");

            // Recopilar todos los resultados únicos
            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[7]; // Index 7 corresponde a la columna 'Resultado Apuesta'
                if (td) {
                    resultado = td.textContent || td.innerText;
                    resultadosUnicos[resultado] = true; // Almacenar en un objeto como clave para evitar duplicados
                }
            }

            // Agregar opciones al menú desplegable
            var select = document.getElementById("filtroResultado");
            for (resultado in resultadosUnicos) {
                var option = document.createElement("option");
                option.value = option.text = resultado;
                select.add(option);
            }
        }

        // Función para filtrar las apuestas
        function filtrarApuestas() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("filtroResultado");
            filter = input.value.toUpperCase();
            table = document.getElementById("tabla1");
            tr = table.getElementsByTagName("tr");

            // Ocultar filas que no coinciden con el filtro
            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[7];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (filter === "" || txtValue.toUpperCase() === filter) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        // Inicializar el filtro al cargar la página
        window.onload = inicializarFiltro;
        </script>

        <table class="tabla-apuestas">
            <thead>
                <tr>
                    <!-- Encabezados de columna para Apuestamanomano -->
                    <th>N°</th> <!-- De Apuestamanomano -->
                    <th>Carrera </th> <!-- De Apuestamanomano -->
                    <th>Fecha</th>
                    <!-- Encabezados de columna para ApuestamanomanoUser y sus relaciones -->
                    <th>Caballo</th> <!-- De Caballo -->
                    <th>Usuario</th> <!-- De User -->
                    <th>CBU</th> <!-- De User -->
                    <th>Telefono</th> <!-- De User -->
                    <th>Monto</th>
                    <th>Resultado Apuesta</th>
                    <th>Estado</th>
                    <!-- Añadir más columnas para los atributos de User y Caballo -->
                </tr>
            </thead>
            <tbody>
                @foreach ($apuestasManoMano as $apuesta)
                <tr>
                    <td>{{ $apuesta->id }}</td>
                    <td>{{ $apuesta->carrera->nombre }}</td>
                    <td>{{ $apuesta->carrera->fecha->format('Y-m-d') }}</td>

                    <!-- Datos del primer usuario relacionado con la apuesta -->
                    @php $apuestaUser = $apuesta->apuestamanomanoUsers->first(); @endphp
                    @if ($apuestaUser)
                        <td>{{ $apuestaUser->caballo->nombre ?? 'N/A' }}</td>
                        <td>{{ $apuestaUser->user->name ?? 'N/A' }}</td>
                        <td>{{ $apuestaUser->user->cbu ?? 'N/A' }}</td>
                        <td>{{ $apuestaUser->user->celular ?? 'N/A' }}</td>
                    @else
                        <td colspan="4">No hay datos de usuario</td>
                    @endif

                    <!-- Montos intercambiados si el tipo es 'recibo' -->
                    <td>
                        @if ($apuesta->Tipo == 'recibo')
                            {{ $apuesta->Monto2 }}
                        @else
                            {{ $apuesta->Monto1 }}
                        @endif
                    </td>

                    <td>{{ $apuestaUser->resultadoapuesta ?? 'N/A' }}</td>
                    <td>
                        {{ $apuesta->Estado ? 'jugada' : 'Pendiente' }}
                    </td>
                </tr>

                <!-- Datos del segundo usuario relacionado con la apuesta, si existe -->
                @if ($apuesta->apuestamanomanoUsers->count() > 1)
                    @php $apuestaUser = $apuesta->apuestamanomanoUsers[1]; @endphp
                    @if ($apuestaUser)
                        <tr>
                            <td>{{ $apuesta->id }}</td>
                            <td>{{ $apuesta->carrera->nombre }}</td>
                            <td>{{ $apuesta->carrera->fecha->format('Y-m-d') }}</td>
                            <td>{{ $apuestaUser->caballo->nombre ?? 'N/A' }}</td>
                            <td>{{ $apuestaUser->user->name ?? 'N/A' }}</td>
                            <td>{{ $apuestaUser->user->cbu ?? 'N/A' }}</td>
                            <td>{{ $apuestaUser->user->celular ?? 'N/A' }}</td>
                            <!-- Montos intercambiados si el tipo es 'recibo' -->
                            <td>
                                @if ($apuesta->Tipo == 'recibo')
                                    {{ $apuesta->Monto1 }}
                                @else
                                    {{ $apuesta->Monto2 }}
                                @endif
                            </td>
                            <td>{{ $apuestaUser->resultadoapuesta ?? 'N/A' }}</td>
                            <td>
                                {{ $apuesta->Estado ? 'jugada' : 'Pendiente' }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="10">No hay datos de usuario</td>
                        </tr>
                    @endif
                @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Otra Tabla (vacía por ahora) -->
    <!-- Otra Tabla para ApuestaPolla y ApuestaPollaUser -->
    <div id="tabla2" style="display:none;">
        <label for="filtroUsuario">Filtrar por Usuario:</label>
        <select id="filtroUsuario" onchange="filtrarPorUsuario()" style="background-color: black; color: white;"></select>

        <script>
        // Función para inicializar el filtro de usuario con valores únicos
        function inicializarFiltroUsuario() {
            var table, tr, td, i, usuario, usuariosUnicos = {};
            table = document.getElementById("tabla2");
            tr = table.getElementsByTagName("tr");

            // Recopilar todos los usuarios únicos
            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[4]; // Index 4 corresponde a la columna 'Usuario'
                if (td) {
                    usuario = td.textContent || td.innerText;
                    usuariosUnicos[usuario] = true; // Almacenar en un objeto como clave para evitar duplicados
                }
            }

            // Agregar opciones al menú desplegable
            var select = document.getElementById("filtroUsuario");
            for (usuario in usuariosUnicos) {
                var option = document.createElement("option");
                option.value = option.text = usuario;
                select.add(option);
            }
        }

        // Función para filtrar las apuestas por usuario
        function filtrarPorUsuario() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById("filtroUsuario");
            filter = input.value.toUpperCase();
            table = document.getElementById("tabla2");
            tr = table.getElementsByTagName("tr");

            // Ocultar filas que no coinciden con el filtro
            for (i = 1; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[4];
                if (td) {
                    txtValue = td.textContent || td.innerText;
                    if (filter === "" || txtValue.toUpperCase() === filter) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        // Función para inicializar ambos filtros al cargar la página
        function inicializarFiltros() {
            inicializarFiltro(); // Esta es tu función existente para el filtro de resultados
            inicializarFiltroUsuario(); // La nueva función para el filtro de usuario
        }

        // Asignar la función de inicialización de filtros al evento de carga de la página
        window.addEventListener('load', inicializarFiltros);
        </script>

        <table class="tabla-apuestas">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Carrera</th>
                    <th>Fecha</th>
                    <th>Caballo</th>
                    <th>Usuario</th>
                    <th>CBU</th>
                    <th>Telefono</th>
                    <th>Monto</th>
                    <th>Resultado Apuesta</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apuestasPolla as $apuesta)
                    @php
                    // Crear un array con los ids de los caballos de la apuesta
                    $idsCaballos = [
                        $apuesta->Caballo1,
                        $apuesta->Caballo2,
                        $apuesta->Caballo3,
                        $apuesta->Caballo4,
                        $apuesta->Caballo5,
                    ];
                    @endphp
                    @foreach ($apuesta->apuestaPollaUsers as $index => $apuestaUser)
                        @if ($index < 5 && in_array($apuestaUser->caballo_id, $idsCaballos))
                            <tr>
                                <td>{{ $apuesta->id }}</td>
                                <td>{{ $apuesta->carrera->nombre }}</td>
                                <td>{{ $apuesta->carrera->fecha->format('Y-m-d') }}</td>
                                <td>{{ $apuestaUser->caballo->nombre ?? 'N/A' }}</td>
                                <td>{{ $apuestaUser->user->name ?? 'N/A' }}</td>
                                <td>{{ $apuestaUser->user->cbu ?? 'N/A' }}</td>
                                <td>{{ $apuestaUser->user->celular ?? 'N/A' }}</td>
                                <td>{{ $apuesta["Monto".(array_search($apuestaUser->caballo_id, $idsCaballos) + 1)] }}</td>
                                <td>{{ $apuestaUser->Resultadoapuesta ?? 'N/A' }}</td>
                                <td>
                                    {{ $apuesta->Estado ? 'jugada' : 'Pendiente' }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
