<x-app-layout>
    <x-slot name="header">
  <!-- Aquí va el código que quieres poner en el header -->
</x-slot>

<div class="container" style="text-align: center; overflow-x: auto;">
   <div class="table-container" style="display: block; margin: 0 auto;">
            <button class="custom-button red" onclick="cambiarTabla('mano')">Mano a mano</button>
            <button class="custom-button green" onclick="cambiarTabla('pollas')">Pollas</button>
            <button class="custom-button orange" onclick="cambiarTabla('llaves')">Llaves</button>
      
        </div>
        </div>
<div style="display: flex; justify-content: center;">

<table id="mano" style="display: block; background-color: black; color: white; margin: auto; max-width: 100%;">
  <thead>
    <tr>
      <th>N°</th>
      <th style="text-align: center;">Carrera</th>
      <th style="text-align: center;">Modo</th>
      <th style="text-align: center;">Jugó en</th>
      <th style="text-align: center; color: white; vertical-align: middle;">Monto</th>
            <th style="text-align: center;">Estado</th>

      <th style="text-align: center;">Resultado</th>
      <th style="text-align: center; color: white; vertical-align: middle;">A depositar</th>
            <th style="text-align: center; color: white; vertical-align: middle;">A depositar</th>

    </tr>
  </thead>
  <tbody>
    @foreach ($apuestasManoAMano as $apuesta)
      @if($apuesta->apuestamanomano->Estado==1)
        <tr style="color: {{ $apuesta->apuestamanomano->Tipo == 'pago' ? 'red' : ($apuesta->apuestamanomano->Tipo == 'doy' ? 'green' : 'orange') }};">
          <td>{{ $apuesta->apuestamanomano->id }}</td>
          <td>{{ $apuesta->apuestamanomano->carrera->nombre }}</td>
          @if ($apuesta->apuestamanomano->Tipo == 'pago')
            <td>Pago a</td>
          @elseif($apuesta->apuestamanomano->Tipo == "recibo")
            <td>Recibo con</td>
          @else
            <td>Doy con</td>
          @endif
          <td>{{ $apuesta->apuestamanomano->Caballo1}}</td>
      
          @if($apuesta->apuestamanomano->Tipo == 'pago')
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


          @if($apuesta->apuestamanomano->Tipo == 'doy')

<td>${{$apuesta->apuestamanomano->Monto1}}</td>
@else
          <td>${{$apuesta->apuestamanomano->Monto2}}</td>

          @endif        
                    @if($apuesta->apuestamanomano->Tipo == 'doy')

<td>${{$apuesta->apuestamanomano->Monto2}}</td>
@else
          <td>${{$apuesta->apuestamanomano->Monto1}}</td>
          </tr>

          @endif  
      @endif
    @endforeach
    <td></td>
   
    @foreach ($apuestasManoAMano as $apuesta)
      @if($apuesta->apuestamanomano->Estado==0)
        <tr style="color: {{ $apuesta->apuestamanomano->Tipo == 'pago' ? 'red' : ($apuesta->apuestamanomano->Tipo == 'doy' ? 'green' : 'orange') }};">
          <td>{{ $apuesta->id }}</td>
          <td>{{ $apuesta->apuestamanomano->carrera->nombre }}</td>
          @if ($apuesta->apuestamanomano->Tipo == 'pago')
            <td>Pago a</td>
          @elseif($apuesta->apuestamanomano->Tipo == "recibo")
            <td>Recibo con</td>
          @else
            <td>Doy con</td>
          @endif
          <td>{{ $apuesta->apuestamanomano->Caballo1}}</td>
        @if($apuesta->apuestamanomano->Tipo == 'pago')
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


          @if($apuesta->apuestamanomano->Tipo == 'doy')

<td>${{$apuesta->apuestamanomano->Monto1}}</td>
@else
          <td>${{$apuesta->apuestamanomano->Monto2}}</td>

          @endif  
                   @if($apuesta->apuestamanomano->Tipo == 'doy')

<td>${{$apuesta->apuestamanomano->Monto2}}</td>
@else
          <td>${{$apuesta->apuestamanomano->Monto1}}</td>

          @endif  
      @endif
       
    @endforeach
  </tbody>
</table>

<table id="pollas" style="display: none; background-color: black; color: white; margin: auto; max-width: 100%;">
  <thead>
    <tr>
      <th>N°</th>
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