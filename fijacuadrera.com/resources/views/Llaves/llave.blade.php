<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
         
        </h2>
    
    </x-slot>
    <div class="container py-5">
        <h2 class="text-center mb-4">Llaves</h2>
        <div class="d-flex justify-content-end mb-3">
            <a href="/llaves/create" class="btn btn-primary">Crear</a>
        </div>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th style="color: white;">ID</th>
                    <th style="color: white;">Número de Llave</th>
                    <th style="color: white;">Llaves Disponibles</th>
                    <th style="color: white;">Llaves Compradas</th>
                    <th style="color: white;">Valor</th>
                    <th style="color: white;">Premio</th>
                    <th style="color: white;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($llaves as $llave)
                    <tr>
                        <td style="color: white;">{{ $llave->id }}</td>
                        <td style="color: white;">{{ $llave->numero_de_llave }}</td>
                        <td style="color: white;">{{ $llave->llaveUser->where('estado', '=', 'Vacante')->where('llave_id', $llave->id)->count() }}</td>

                        <td style="color: white;">{{ $llave->llaveUser->where('estado', '=', 'Vendida')->where('llave_id', $llave->id)->count() }}</td>
                        <td style="color: white;">{{ $llave->valor }}</td>
                        <td style="color: white;">{{ $llave->premio }}</td>
                        <td>
                            <button class="btn btn-sm btn-info" onclick="$('#details-{{ $llave->id }}').toggle()">Mostrar</button>
                        </td>
                    </tr>
                    <tr id="details-{{ $llave->id }}" style="display: none">
                        <td colspan="7">
                            <!-- Aquí puedes renderizar los detalles de la llave en forma de tabla -->
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th style="color: white;">Llave</th>
                                        <th style="color: white;">Usuario</th>
                                        <th style="color: white;">Estado</th>
                                        <th style="color: white;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($llave->llaveUsers as $llaveUser)
                                        <tr>
                                            <td style="color: white;">{{ $llaveUser->combinacion }}</td>
                                            <td style="color: white;">
                                                @if ($user->admin == 1 && $llaveUser->estado == 'Vacante') 
                                                @else
                                                    {{ $llaveUser->userName }} {{ $llaveUser->userDni }}
                                                @endif
                                            </td>     
                                            <td style="color: white;">{{ $llaveUser->estado == 0 ? 'Pendiente' : $llaveUser->estado }}</td>
                                            <!-- Colocar el botón dentro de una celda de tabla -->
                                            <td>
                                                <form action="{{ route('llaves.ganar', [$llave->id, $llaveUser->id]) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="llave_id" value="{{ $llave->id }}">
                                                    <input type="hidden" name="llaveUser_id" value="{{ $llaveUser->id }}">
                                                    <button type="submit" class="btn btn-success">LLave Ganadora</button>
                                                </form>
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
    <!-- CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- JS de Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</x-app-layout>


