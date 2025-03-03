<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            Crear Llave
        </h2>
    </x-slot>
    <div class="container py-5">
        <form action="/llaves" method="POST">
            @csrf
            <div class="form-group">
                <label for="numero_de_llave">Número de Llave</label>
                <input type="number" class="form-control" id="numero_de_llave" name="numero_de_llave" required>
            </div>
            <div id="caballos">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="caballo_1_1">Caballo 1 - Par 1</label>
                        <select class="form-control" id="caballo_1_1" name="caballo_1_1">
                            @foreach ($caballos as $caballo)
                                <option value="{{ $caballo->id }}">{{ $caballo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="caballo_2_1">Caballo 2 - Par 1</label>
                        <select class="form-control" id="caballo_2_1" name="caballo_2_1">
                            @foreach ($caballos as $caballo)
                                <option value="{{ $caballo->id }}">{{ $caballo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <button type="button" id="agregar" class="btn btn-secondary mb-3">Agregar más caballos</button>
            <div class="form-group">
                <label for="valor">Valor</label>
                <input type="number" step="0.01" class="form-control" id="valor" name="valor" required>
            </div>
            <div class="form-group">
                <label for="premio">Premio</label>
                <input type="number" step="0.01" class="form-control" id="premio" name="premio" required>
            </div>
            <button type="submit" class="btn btn-primary">Crear</button>
            <a href="/llaves" class="btn btn-secondary">Volver</a>
        </form>
    </div>
    <!-- CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- JS de Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      $(document).ready(function() {
    var i = 2;
    $('#agregar').click(function() {
        if (i <= 10) {
            $('#caballos').append(`
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="caballo_1_${i}">Caballo 1 - Par ${i}</label>
                        <select class="form-control" id="caballo_1_${i}" name="caballo_1_${i}">
                            @foreach ($caballos as $caballo)
                                <option value="{{ $caballo->id }}">{{ $caballo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="caballo_2_${i}">Caballo 2 - Par ${i}</label>
                        <select class="form-control" id="caballo_2_${i}" name="caballo_2_${i}">
                            @foreach ($caballos as $caballo)
                                <option value="{{ $caballo->id }}">{{ $caballo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            `);
            i++;
        }
    });
});

    </script>
</x-app-layout>

