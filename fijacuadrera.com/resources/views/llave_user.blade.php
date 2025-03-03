<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white-800 leading-tight text-center">
            Llaves Disponibles
        </h2>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    </x-slot>

    <div class="py-12 bg-black"> <!-- Fondo negro para toda la sección -->
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-black overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-black text-white border-b border-gray-200"> <!-- Fondo negro y texto blanco -->
                    <div id="message" class="alert" style="display: none"></div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead >
                                <tr >
                                   
                                      <th style="color: white;">N°</th>
        <th style="color: white;">Clasicos de LLaves</th>
        <th style="color: white;">Valor</th>
        <th style="color: white;">Premio</th>
        <th style="color: white;"> Disponibles</th>
        <th style="color: white;">Vendidas</th>
        <th style="color: white;">Ventas de llaves</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($llaves as $llave)
                                    <tr>
                                        
                                        <td style="color: white;" >{{ $llave->numero_de_llave }}</td>
                                  <td style="color: white;">
    @foreach ($llave->parejas as $pareja)
        {{ $pareja }}<br>
    @endforeach
</td>
                                           <td style="color: white;">{{ $llave->valor }}</td>
                                        <td style="color: white;">{{ $llave->premio }}</td>
                                        <td style="color: white;">{{ $llave->llaveUser->where('estado', 'Vacante')->where('llave_id', $llave->id)->count() }}</td>
                                        <td style="color: white;">{{ $llave->llaveUser->where('estado', '!=', 'Vacante')->where('llave_id', $llave->id)->count() }}</td>
                                     
                                        <td>
                                            <button class="btn btn-sm btn-info" onclick="toggleDetails({{ $llave->id }})">Mostrar</button>
                                        </td>
                                    </tr>
                                    <tr id="details-{{ $llave->id }}" style="display: none">
                                        <td colspan="7">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="color: white;">N°</th>
                                                        <th style="color: white;">Llave</th>
                                                         <th style="color: white;">Valor</th>
                                                         <th style="color: white;">Premio</th>
                                                        <th style="color: white;">Estado</th>
                                                        <th style="color: white;">Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($llave->llaveUsers as $llaveUser)
                                                        <tr>
                                                                 

                                                            <td style="color: white;">{{ $llave->numero_de_llave }}({{ $llaveUser->id }})</td>
                                                            <td style="color: white;">
                                                                <img src="{{ asset('/imagenes/Logo.jpeg') }}" alt="Llave" style="width: 1em; height: 1em; display: inline-block; vertical-align: middle;">
                                                                <span style="display: inline-block; vertical-align: middle;">{{ $llaveUser->combinacion }}</span>
                                                            </td>
                                                            
                                                               <td style="color: white;">{{ $llave->valor }}</td>
                                                                  <td style="color: white;">{{ $llave->premio }}</td>
                                                            <td style="color: white;">{{ $llaveUser->estado == 0 ? 'Vacante' : $llaveUser->estado }}</td>
                                                      
                                                                <td style="color: white;">
                                                                    @if ((string) $llaveUser->estado === 'Vacante')
                                                                        <button class="btn btn-primary text-black" onclick="comprarLlave({{ $llaveUser->id }})">Comprar llave</button>
                                                                    @endif
                                                                </td>
                                                                
                                                       
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleDetails(id) {
            var details = document.getElementById('details-' + id);
            if (details.style.display === 'none') {
                details.style.display = 'table-row';
            } else {
                details.style.display = 'none';
            }
        }

        function comprarLlave(id) {
            // Muestra un modal de confirmación antes de comprar la llave
            if (confirm('¿Estás seguro de que quieres comprar esta llave?')) {
                // Si el usuario confirma, envía una solicitud POST al servidor para comprar la llave
                fetch('/comprar-llave/' + id, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Muestra el mensaje de éxito o error
                    var message = document.getElementById('message');
                    if (data.success) {
                        message.className = 'alert alert-success';
                        message.textContent = data.success;
                    } else if (data.error) {
                        message.className = 'alert alert-danger';
                        message.textContent = data.error;
                    }
                    message.style.display = 'block';

                    // Actualiza la página para reflejar los cambios
                    location.reload();
                });
            }
        }
    </script>
</x-app-layout>


