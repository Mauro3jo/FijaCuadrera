<x-app-layout>
    <x-slot name="header">
  <!-- Aquí va el código que quieres poner en el header -->
</x-slot>

<div class="container" style="text-align: center; overflow-x: auto;">
  <div class="table-container" style="display: block; margin: 0 auto;">
      <!-- Selector de usuario centrado en el medio -->
      <div style="margin-bottom: 20px;">
        <select id="userFilter" onchange="filterByUser()" style="width: 200px; margin: auto; display: block; background-color: black; color: white;">
            <option value="">Todos los usuarios</option>
            @php
                $userNames = collect();
                foreach ($apuestasManoAMano as $apuesta) {
                    $userNames->push($apuesta->user->name);
                }
                foreach ($apuestasPolla as $detalleApuesta) {
                    $userNames->push($detalleApuesta['nombre_usuario']);
                }
                foreach ($llaves as $llave) {
                    $userNames->push($llave->nombre_usuario);
                }
                $userNames = $userNames->unique();
            @endphp
            @foreach ($userNames as $userName)
                <option value="{{ $userName }}">{{ $userName }}</option>
            @endforeach
        </select>
    </div>
    
      <!-- Botones debajo del selector -->
      <div>
          <button class="custom-button red" onclick="cambiarTabla('mano')">Mano a mano</button>
          <button class="custom-button green" onclick="cambiarTabla('pollas')">Pollas</button>
          <button class="custom-button orange" onclick="cambiarTabla('llaves')">Llaves</button>
      </div>
  </div>
</div>
<script>
  function filterByUser() {
      var input = document.getElementById("userFilter");
      var filter = input.value.toUpperCase();
      var tables = document.querySelectorAll("#mano, #pollas, #llaves"); // Asegúrate de que estos son los IDs correctos de tus tablas
  
      tables.forEach(table => {
          var tr = table.getElementsByTagName("tr");
          for (var i = 1; i < tr.length; i++) {
              var td = tr[i].getElementsByTagName("td")[1]; // Asume que el nombre del usuario está en la segunda columna
              if (td) {
                  var txtValue = td.textContent || td.innerText;
                  if (txtValue.toUpperCase().indexOf(filter) > -1 || filter === "") {
                      tr[i].style.display = "";
                  } else {
                      tr[i].style.display = "none";
                  }
              }
          }
      });
  }
  </script>


<div style="display: flex; justify-content: center;">

<table id="mano" style="display: block; background-color: black; color: white; margin: auto; max-width: 100%;">
  <thead>
    <tr>
      <th>N°</th>
      <th style="text-align: center;">Usuario</th>

      <th style="text-align: center;">Carrera</th>
      <th style="text-align: center;">Modo</th>
      <th style="text-align: center;">Jugó en</th>
      <th style="text-align: center; color: white; vertical-align: middle;">Monto</th>
            <th style="text-align: center;">Estado</th>

      <th style="text-align: center;">Resultado</th>
      <th style="text-align: center; color: white; vertical-align: middle;">A depositar</th>
    </tr>
  </thead>
  <tbody>
      @php $contador = 0; @endphp

    @foreach ($apuestasManoAMano as $apuesta)
      @if($apuesta->apuestamanomano->Estado==1)
          @php $contador++; @endphp

        <tr style="color: {{ $apuesta->Tipo == 'pago' ? 'red' : ($apuesta->Tipo == 'doy' ? 'green' : 'orange') }};">
          <td>{{ $apuesta->apuestamanomano->id }}</td>
          <td>{{ $apuesta->user->name }}</td> <!-- Aquí insertamos el nombre del usuario -->

          <td>{{ $apuesta->apuestamanomano->carrera->nombre }}</td>
        @if ($apuesta->Tipo == 'pago')
            <td>Pago a</td>
          @elseif($apuesta->Tipo == "recibo")
            <td>Recibo con</td>
          @else
            <td>Doy con</td>
          @endif
 @if ($contador % 2 == 1)
        <td>{{ $apuesta->Caballo->nombre }}</td> <!-- En la primera vuelta, muestra Caballo1 -->
      @else
        <td>{{ $apuesta->Caballo->nombre }}</td> <!-- En la primera vuelta, muestra Caballo1 -->
      @endif          @if($apuesta->apuestamanomano->Tipo == 'doy')
            <td>${{ $apuesta->apuestamanomano->Monto1 }} A ${{$apuesta->apuestamanomano->Monto2}}</td>
          @elseif($apuesta->apuestamanomano->Tipo == 'pago')
            <td>${{ $apuesta->apuestamanomano->Monto1 }}</td>
            @else
                        <td>${{ $apuesta->apuestamanomano->Monto1 }} A ${{$apuesta->apuestamanomano->Monto2}}</td>

          @endif
          <td>
  @if ($apuesta->apuestamanomano->Estado == 0)
    Pendiente
  @elseif ($apuesta->apuestamanomano->Estado == 1)
    Jugada
  @else
    Desconocido
  @endif
</td>
          <td>{{ $apuesta->resultadoapuesta }}</td>


          @if($apuesta->Tipo == 'doy')

<td>${{$apuesta->apuestamanomano->Monto1}}</td>
@else
          <td>${{$apuesta->apuestamanomano->Monto2}}</td>

          @endif        </tr>
      @endif
    @endforeach
    <td></td>

    @foreach ($apuestasManoAMano as $apuesta)
      @if($apuesta->apuestamanomano->Estado==0)
          @php $contador++; @endphp
        <tr style="color: {{ $apuesta->apuestamanomano->Tipo == 'pago' ? 'red' : ($apuesta->apuestamanomano->Tipo == 'doy' ? 'green' : 'orange') }};">
          <td>{{ $apuesta->id }}</td>
                    <td>{{ $apuesta->user->name }}</td> <!-- Aquí insertamos el nombre del usuario -->

          <td>{{ $apuesta->apuestamanomano->carrera->nombre }}</td>
          @if ($apuesta->apuestamanomano->Tipo == 'pago')
            <td>Pago a</td>
          @elseif($apuesta->apuestamanomano->Tipo == "recibo")
            <td>Recibo con</td>
          @else
            <td>Doy con</td>
          @endif
 @if ($contador % 2 == 1)
        <td>{{ $apuesta->Caballo->nombre }}</td> <!-- En la primera vuelta, muestra Caballo1 -->
      @else
        <td>{{ $apuesta->Caballo->nombre }}</td> <!-- En la primera vuelta, muestra Caballo1 -->
      @endif            @if($apuesta->apuestamanomano->Tipo == 'doy')
            <td>${{ $apuesta->apuestamanomano->Monto1 }} A ${{$apuesta->apuestamanomano->Monto2}}</td>
          @elseif($apuesta->apuestamanomano->Tipo == 'pago')
            <td>${{ $apuesta->apuestamanomano->Monto1 }}</td>
            @else
                        <td>${{ $apuesta->apuestamanomano->Monto1 }} A ${{$apuesta->apuestamanomano->Monto2}}</td>

          @endif
          <td>
  @if ($apuesta->apuestamanomano->Estado == 0)
    Pendiente
  @elseif ($apuesta->apuestamanomano->Estado == 1)
    Jugada
  @else
    Desconocido
  @endif
</td>
          <td>{{ $apuesta->resultadoapuesta }}</td>


          @if($apuesta->Tipo == 'doy')

<td>${{$apuesta->apuestamanomano->Monto1}}</td>
@else
          <td>${{$apuesta->apuestamanomano->Monto2}}</td>

          @endif        </tr>
      @endif
    @endforeach
  </tbody>
</table>

<table id="pollas" style="display: none; background-color: black; color: white; margin: auto; max-width: 100%;">
  <thead>
    <tr>
      <th>N°</th>
      <th style="text-align: center;">Usuario</th>

      <th>Polla</th>
      <th>Monto</th>
            <th>Jugo en</th>
                <th>Estado</th>
      <th style="text-align: center; color: white; vertical-align: middle;">A depositar</th>
            <th>Resultado de Apuesta</th>

    </tr>
  </thead>
<tbody>
@foreach ($apuestasPolla as $detalleApuesta)
  <tr>
    <td>{{ $detalleApuesta['apuesta_polla_id'] }}</td>
    <td>{{ $detalleApuesta['nombre_usuario'] }}</td> <!-- Nombre del usuario para apuestas de polla -->

    <td>
      @foreach ($detalleApuesta['caballos'] as $nombreCaballo)
        {{ $nombreCaballo }}<br>
      @endforeach
    </td>
    <td>
      @foreach ($detalleApuesta['montos'] as $monto)
        {{ $monto }}<br>
      @endforeach
    </td>
    <td>
      @foreach ($detalleApuesta['CaballoJugado'] as $index => $nombreCaballo)
        {{ $nombreCaballo }}<br>
      @endforeach
    </td>
    <td>
      @foreach ($detalleApuesta['estado'] as $estado)
        {{ $estado }}
        @break
      @endforeach
    </td>
    <td>
      @foreach ($detalleApuesta['a_depositar'] as $index => $depositar)
        {{ $depositar }}<br>
      @endforeach
    </td>
    <td>
      @foreach ($detalleApuesta['resultado_apuesta'] as $index => $resultado)
        {{ $resultado }}<br>
      @endforeach
    </td>
  </tr>
@endforeach
</tbody>

</table>



<table id="llaves" style="display: none; background-color: black; color: white; margin: auto; max-width: 100%;">
  <thead>
    <tr>
      <th>N°</th>
      <th style="text-align: center;">Usuario</th>

      <th>Llave ID</th>
      <th>Combinación</th>
      <th>Estado</th>
      <th>Valor</th> 
      <th>A depositar</th><!-- Agregado: Mostrar el valor de la llave -->
    </tr>
  </thead>
  <tbody>
    @foreach ($llaves as $llave)
      @if ($llave->estado === 'Vendida')
        <tr>
          <td>{{ $llave->id }}</td>
          <td>{{ $llave->nombre_usuario }}</td> <!-- Nombre del usuario para llaves -->

          <td>{{ $llave->llave_id }}</td>
          <td>{{ $llave->combinacion }}</td>
          <td>{{ $llave->estado }}</td>
          <td>{{ $llave->llave->valor }}</td> <!-- Mostrar el valor de la llave -->
          <td>{{ $llave->llave->valor }}</td> 
        </tr>
      @endif
    @endforeach
  </tbody>
</table>


    </div>
 </div>

  <style>
        /* Estilos para los botones */
        .custom-button {
            padding: 10px 20px;
            margin: 5px;
            font-size: 16px;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
.table, th, td{
  border: 1px solid white;
   padding: 6px 12px;
}
        /* Estilos para los botones 'mano a mano', 'pollas' y 'llaves' */
        .custom-button.red {
            background-color: #FF4500; /* Color rojo */
        }

        .custom-button.green {
            background-color: #27ae60; /* Color verde */
        }

        .custom-button.orange {
            background-color: #f39c12; /* Color naranja */
        }
          .custom-button {
            background-color: #1E90FF; /* Color naranja FF4500 */
        }
              .custom-button.depo {
            background-color: #FF4500; /* Color naranja FF4500 */
        }

        .custom-button:hover {
            opacity: 0.8; /* Reducir la opacidad al pasar el cursor */
        }
          .custom-button-depo :hover {
            opacity: 0.8; /* Reducir la opacidad al pasar el cursor */
        }

        @media only screen and (max-width: 600px) {
            table {
                font-size: 14px;
            }
        }
    </style>

<script>

  function cambiarTabla(tabla) {
    // Ocultar todas las tablas
    document.getElementById("mano").style.display = "none";
    document.getElementById("pollas").style.display = "none";
    document.getElementById("llaves").style.display = "none";
    // Mostrar la tabla seleccionada
    document.getElementById(tabla).style.display = "block";
  }

  function filtrarTabla(filtro) {
    // Obtener todas las filas de la tabla actual
    var tabla = document.getElementById("tabla").value;
    var filas = document.getElementById(tabla).getElementsByTagName("tr");
    // Recorrer las filas y ocultar las que no cumplen el filtro
    for (var i = 0; i < filas.length; i++) {
      // Obtener el estado de la fila
      var estado = filas[i].getElementsByTagName("td")[5].innerHTML;
      // Si el filtro está activo y el estado es pendiente, ocultar la fila
      if (filtro && estado == "Pendiente") {
        filas[i].style.display = "none";
      } else {
        // Si no, mostrar la fila
        filas[i].style.display = "block";
      }
    }
  }
</script>

</x-app-layout>