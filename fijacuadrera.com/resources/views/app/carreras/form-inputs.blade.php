@php $editing = isset($carrera) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="nombre"
            label="Nombre"
            :value="old('nombre', ($editing ? $carrera->nombre : ''))"
            maxlength="255"
            placeholder="Nombre"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.datetime
            name="fecha"
            label="Fecha"
            value="{{ old('fecha', ($editing ? optional($carrera->fecha)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
            required
        ></x-inputs.datetime>
    </x-inputs.group>
    <x-inputs.group class="w-full">
        <x-inputs.partials.label name="imagen" label="Imagen" ></x-inputs.partials.label>
        
        <input type="file" name="imagen" id="imagen" class="form-control-file" @if($editing)  @endif>
        
        @if($editing && $carrera->imagen)
            <div>
                <img src="{{ Storage::url($carrera->imagen) }}" alt="">
            </div>
        @endif
    </x-inputs.group>
    
    
    
    
    <x-inputs.group class="w-full">
        <x-inputs.select name="hipico_id" label="Hipico" required>
            @php $selected = old('hipico_id', ($editing ? $carrera->hipico_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Seleccione el hipico</option>
            @foreach($hipicos as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
    @for ($i = 0; $i < 5; $i++)
    <x-inputs.group class="w-full">
        <label for="caballo_{{ $i + 1 }}" style="color: #000;">Caballo {{ $i + 1 }}</label>
        <select id="caballo_{{ $i + 1 }}" name="caballos[]" class="js-example-basic-single" required>
            @php $selected = old('caballos.'.$i, ($editing && isset($caballos_carrera->caballos[$i]) ? optional($caballos_carrera->caballos[$i])->id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Por favor, selecciona el Caballo {{ $i + 1 }}</option>
            @foreach($caballos as $value => $label)
                <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        @if ($editing && isset($caballos_carrera->caballos[$i]))
            <x-inputs.text
                name="resultados[]"
                label="Resultado"
                :value="old('resultados.'.$i, optional($caballos_carrera->caballos[$i])->pivot->resultado)"
                placeholder="Resultado"
            ></x-inputs.text>
        @endif
    </x-inputs.group>
@endfor


</div>
<style>
    .select2-container--default .select2-selection--single,
    .select2-container--default .select2-selection--single .select2-selection__rendered,
    .select2-container--default .select2-selection--single .select2-search__field,
    .select2-container--default .select2-results__option,
    .select2-container--default .select2-search--dropdown .select2-search__field {
        color: #000 !important; /* Cambia el color de la letra a negro */
    }
    .select2-container--default .select2-selection--single {
        background-color: #fff; /* Fondo blanco para el campo de selección */
        border: 1px solid #aaa; /* Borde gris para el campo de selección */
    }
    .select2-dropdown {
        background-color: #fff; /* Fondo blanco para el desplegable */
    }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<script>
    $(document).ready(function() {
        // Inicializar Select2 para los campos 'caballos[]'
        $('.js-example-basic-single').select2({
            placeholder: "Selecciona un caballo",
            allowClear: true,
            minimumInputLength: 1, // Los usuarios deben tipear al menos 1 carácter para iniciar la búsqueda
            language: {
                inputTooShort: function() {
                    return "Por favor ingresa 1 o más caracteres"; // Mensaje cuando no se han ingresado suficientes caracteres
                }
            }
        });
    });
</script>