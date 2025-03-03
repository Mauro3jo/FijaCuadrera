<nav x-data="{ open: false }" class="bg-black border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <img src="/imagenes/Logo.jpeg" class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>
                

                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="bg-blue-500 border-blue-500 text-white">
                        <i class="bi bi-house text-white"></i>
                        {{ __('Inicio') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('reuniones')" :active="request()->routeIs('reuniones')" class="bg-blue-500 border-blue-500 text-white">
                        <i class="bi bi-people text-white"></i>
                        {{ __('Reuniones') }}
                    </x-nav-link>
            
                    
               @php
    $contadorEstadoCeroApuestaPolla = \App\Models\ApuestaPolla::where('Estado', 0)->count();
    $contadorEstadoCeroApuestaManoMano = \App\Models\Apuestamanomano::where('Estado', 0)->count();
    $totalContadorEstadoCero = $contadorEstadoCeroApuestaPolla + $contadorEstadoCeroApuestaManoMano;
@endphp


<x-nav-link :href="route('carreras.apuestas.todas')" :active="request()->routeIs('carreras.apuestas.todas')" class="bg-blue-500 border-blue-500 text-white flex flex-row items-center">
    <i class="fa fa-horse text-white"></i>
    <span>{{ __('Salon de apuestas') }}</span>
    <span class="badge badge-warning ml-2" style="font-size: 1.5rem !important;">{{ $totalContadorEstadoCero }}</span>
</x-nav-link>



                    
                    <x-nav-link :href="route('cargar.saldo')" :active="request()->routeIs('cargar.saldo')" class="bg-blue-500 border-blue-500 text-white">
                        <i class="bi bi-cash text-white"></i>
                        {{ __('Cargar saldo') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('llaves2')" :active="request()->routeIs('llaves2')" class="bg-blue-500 border-blue-500 text-white">
                        <i class="bi bi-key text-white"></i>
                        {{ __('Llaves') }}
                    </x-nav-link>
                  <x-nav-link :href="route('historial-jugadas')" :active="request()->routeIs('historial-jugadas')" class="bg-blue-500 border-blue-500 text-white text-center flex justify-center">
    <i class="bi bi-clock-history text-white"></i>
    {{ __('Mis Paradas') }}
</x-nav-link>

                    <!-- Agrega estos dos botones a tu página web -->
<x-nav-link :href="route('ayuda')" :active="request()->routeIs('ayuda')" class="bg-blue-500 border-blue-500 text-white">
    <i class="bi bi-question-circle text-white"></i>
    {{ __('Ayuda') }}
</x-nav-link>

<x-nav-link :href="route('reglamento')" :active="request()->routeIs('reglamento')" class="bg-blue-500 border-blue-500 text-white">
    <i class="bi bi-book text-white"></i>
    {{ __('Reglamento') }}
</x-nav-link>

                    
                             
                                @if (auth()->user()->admin == 1)
                    <x-nav-dropdown title="Administrador" align="right" width="48" style="color: white">
                        <x-dropdown-link :href="route('historiales.index')">
                            {{ __('Historiales') }}
                        </x-dropdown-link>
                        <x-dropdown-link href="{{ route('users.index') }}">
                            Usuarios
                        </x-dropdown-link>
                        @can('view-any', App\Models\Caballo::class)
                            <x-dropdown-link href="{{ route('caballos.index') }}">
                              Cargar  Caballos
                            </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Carrera::class)
                            <x-dropdown-link href="{{ route('carreras.index') }}">
                            Cargar    Carreras
                            </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Contacto::class)
                            <x-dropdown-link href="{{ route('contactos.index') }}">
                                Contactos
                            </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Formapago::class)
                            <x-dropdown-link href="{{ route('formapagos.index') }}">
                                Formapagos
                            </x-dropdown-link>
                        @endcan
                        @can('view-any', App\Models\Hipico::class)
                            <x-dropdown-link href="{{ route('hipicos.index') }}">
                          Cargar      Hipicos
                            </x-dropdown-link>
                        @endcan
                        <x-responsive-nav-link href="{{ route('llaves') }}">
                      Crear      Llaves
                        </x-responsive-nav-link>
                        <x-responsive-nav-link href="{{ route('admin.apuestas-armadas2') }}">
                         Paradas Jugadas
                        </x-responsive-nav-link>
                        
                        <x-responsive-nav-link :href="route('admin.usuarios.listado')" :active="request()->routeIs('admin.usuarios.listado')">
                        Datos de Ganadores y Perdedores
                        </x-responsive-nav-link>
                         <x-dropdown-link :href="route('admin.apuestamanomanos.index')" :active="request()->routeIs('admin.apuestamanomanos.index')">
            <i class="bi bi-table text-white"></i>
            {{ __('Tabla de Apuestas') }}
        </x-dropdown-link>
                    </x-nav-dropdown>
                @endif
                </div>
                
                
                <x-nav-dropdown title="Estado de Cuenta" align="right" width="48">
                    <!-- Calcular total jugado -->
               @php
    $totalJugado = 0;
    $totalPendiente = 0;

    // Calcular total jugado para Apuestamanomano
    $apuestasManoMano = auth()->user()->apuestamanomanoUsers()->with('apuestamanomano')->get();
    foreach ($apuestasManoMano as $apuestaUser) {
        $apuestaManoAMano = $apuestaUser->apuestamanomano;

        // Obtener todas las apuestas asociadas a la apuesta mano a mano correspondiente
        $apuestasRelacionadas = \App\Models\ApuestamanomanoUser::where('apuestamanomano_id', $apuestaManoAMano->id)->get();
        $apuesta = $apuestaUser->apuestamanomano;

        // Definir el tipo temporalmente
        $tipo = $apuestaManoAMano->Tipo;

        if ($apuestasRelacionadas->count() == 2) {
            // Obtener la apuesta con el ID más pequeño
            $primeraApuesta = $apuestasRelacionadas->sortBy('id')->first();
            if ($apuestaUser->id != $primeraApuesta->id) {
                // Cambiar el tipo si no es la primera apuesta
                if ($tipo === 'recibo') {
                    $tipo = 'doy';
                } elseif ($tipo === 'doy') {
                    $tipo = 'recibo';
                }
            }
        }

        if ($apuestaUser->apuestamanomano->Estado == 0 && $apuestaUser->resultadoapuesta == "pendiente") {
            if ($tipo == "pago") {
                $totalPendiente += $apuesta->Monto1;
            } elseif ($tipo == "doy") {
                $totalPendiente += $apuesta->Monto1;
            } elseif ($tipo == "recibo") {
                $totalPendiente += $apuesta->Monto2;
            }
        } else {
            if ($apuestaUser->resultadoapuesta == "pendiente") {
                if ($tipo == "pago") {
                    $totalJugado += $apuesta->Monto1;
                } elseif ($tipo == "doy") {
                    $totalJugado += $apuesta->Monto1;
                } elseif ($tipo == "recibo") {
                    $totalJugado += $apuesta->Monto2;
                }
            }
        }
    }

    // Calcular total jugado y pendiente para ApuestaPolla
    $apuestasPolla = auth()->user()->apuestaPollaUsers()->with('apuestaPolla')->get();
    foreach ($apuestasPolla as $apuestaUser) {
        $apuestaPolla = $apuestaUser->apuestaPolla;

        // Determinar el monto apostado por el usuario
        $montos = [$apuestaPolla->Monto1, $apuestaPolla->Monto2, $apuestaPolla->Monto3, $apuestaPolla->Monto4, $apuestaPolla->Monto5];
        $caballos = [$apuestaPolla->Caballo1, $apuestaPolla->Caballo2, $apuestaPolla->Caballo3, $apuestaPolla->Caballo4, $apuestaPolla->Caballo5];
        $montoApostado = 0;

        foreach ($caballos as $index => $caballoId) {
            if ($apuestaUser->caballo_id == $caballoId) {
                $montoApostado += $montos[$index]; // Sumar el monto al total
            }
        }

        // Sumar al total jugado o pendiente según el estado de la apuesta
        if ($apuestaPolla->Estado == 1 && $apuestaUser->Resultadoapuesta === 'Pendiente') {
            $totalJugado += $montoApostado;
        } elseif ($apuestaPolla->Estado == 0 && $apuestaUser->Resultadoapuesta === 'Pendiente') {
            $totalPendiente += $montoApostado;
        }
    }
@endphp



                
                    <!-- Mostrar total jugado -->
                    <x-dropdown-link>
                        Total Jugado: ${{ $totalJugado }}
                    </x-dropdown-link>
                    <!-- Mostrar total pendiente -->
                    <x-dropdown-link>
                        Total Pendiente: ${{ $totalPendiente }}
                    </x-dropdown-link>
                    <!-- Mostrar saldo para jugar -->
                    <x-dropdown-link>
                        Saldo para jugar: {{ auth()->user()->saldo }}
                    </x-dropdown-link>
                </x-nav-dropdown>
                    <x-nav-dropdown title="Resumen" style="color: white !important;">
   <x-dropdown-link>
                            Jugo: {{ auth()->user()->Jugo }}
                        </x-dropdown-link>
                        <x-dropdown-link>
                            Gano: {{ auth()->user()->Gano }}
                        </x-dropdown-link>
                         
                        <x-dropdown-link>
                            Perdio: {{ auth()->user()->Perdio }}
                        </x-dropdown-link>
                        <x-dropdown-link>
                            Comision: {{ auth()->user()->Comision }}
                        </x-dropdown-link>
                       <x-dropdown-link>
    @if (auth()->user()->Gano - (auth()->user()->Perdio + auth()->user()->Comision) >= 0)
        A Cobrar {{ auth()->user()->Gano - (auth()->user()->Perdio + auth()->user()->Comision) }}
    @else
        A Pagar {{ auth()->user()->Gano - (auth()->user()->Perdio + auth()->user()->Comision) }}
    @endif
</x-dropdown-link>

                    </x-nav-dropdown>
                    
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-white-500 hover:text-white-700 hover:border-white-300 focus:outline-none focus:text-white-700 focus:border-white-300 transition duration-150 ease-in-out">
                            <div class="ml-3">
                                <div class="font-medium text-base text-white-800" style="margin-bottom: 10px;">{{ 'Usuario' }}</div>
                            </div>
                            
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link>
                         {{ auth()->user()->name }}
                        </x-dropdown-link>
                        
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-dropdown-link>
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Salir') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Inicio') }}
            </x-responsive-nav-link>
         
           <x-responsive-nav-link :href="route('reuniones')" :active="request()->routeIs('reuniones')" class="bg-blue-500 border-blue-500 text-white">
                        <i class="bi bi-people text-white"></i>
                        {{ __('Reuniones') }}
                    </x-responsive-nav-link>
<x-nav-link :href="route('carreras.apuestas.todas')" :active="request()->routeIs('carreras.apuestas.todas')" class="bg-blue-500 border-blue-500 text-white md:bg-red-500 md:border-red-500 flex items-center justify-between px-3 py-2">
    <i class="fa fa-horse text-white"></i>
    <span>{{ __('Salón de apuestas') }}</span>
    <span class="badge badge-warning">{{ $totalContadorEstadoCero }}</span>
</x-nav-link>




              <x-responsive-nav-link :href="route('cargar.saldo')" :active="request()->routeIs('cargar.saldo')" class="bg-blue-500 border-blue-500 text-white">
                        <i class="bi bi-cash text-white"></i>
                        {{ __('Cargar saldo') }}
                    </x-responsive-nav-linkk>
                    
                    <x-responsive-nav-link :href="route('llaves2')" :active="request()->routeIs('llaves2')" class="bg-blue-500 border-blue-500 text-white">
                        <i class="bi bi-key text-white"></i>
                        {{ __('Llaves') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('historial-jugadas')" :active="request()->routeIs('historial-jugadas')" class="bg-blue-500 border-blue-500 text-white">
                        <i class="bi bi-clock-history text-white"></i>
                        {{ __('Paradas') }}
                    </x-responsive-nav-link>
                    <!-- Agrega estos dos botones a tu página web -->
<x-responsive-nav-link :href="route('ayuda')" :active="request()->routeIs('ayuda')" class="bg-blue-500 border-blue-500 text-white">
    <i class="bi bi-question-circle text-white"></i>
    {{ __('Ayuda') }}
</x-responsive-nav-link>

<x-responsive-nav-link :href="route('reglamento')" :active="request()->routeIs('reglamento')" class="bg-blue-500 border-blue-500 text-white">
    <i class="bi bi-book text-white"></i>
    {{ __('Reglamento') }}
</x-responsive-nav-link>

        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="shrink-0">
                    <svg class="h-10 w-10 fill-current text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>

                <div class="ml-3">
                    
                    <div class="font-medium text-base text-white-800" style="margin-bottom: 10px;">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-base text-white-800">Saldo: {{ Auth::user()->saldo }}</div>
                   <div class="font-medium text-base text-white-800"> Total Jugado: ${{ $totalJugado }}</div>
                    <div class="font-medium text-base text-white-800">Total Pendiente: ${{ $totalPendiente }}</div>
                    <div class="font-medium text-base text-white-800"> Saldo para jugar: {{ auth()->user()->saldo }}</div>

                  
                </div>
                
            </div>

            <div class="mt-3 space-y-1">
                
                 <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Total Jugado') }}
                </x-dropdown-link>
                
                 <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Saldo') }}
                </x-dropdown-link>
                
                 <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Usuario') }}
                </x-dropdown-link>
                
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-dropdown-link>
                
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Salir') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>