<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" style="background: url('/imagenes/Fondo.jpeg') no-repeat center center fixed; -webkit-background-size: 100% 100%; -moz-background-size: 100% 100%; -o-background-size: 100% 100%; background-size: 100% 100%;">

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Fija Cuadrera</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            .btn {
                background-color: #DAA520; /* Golden */
                border: none;
                color: #000; /* Black */
                padding: 15px 32px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 16px;
                margin: 4px 2px;
                cursor: pointer;
        
                /* New styles */
                border-radius: 50px; /* Rounded corners */
                box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
                transition: 0.3s;
                background: linear-gradient(to right, #DAA520, #ffd700); /* Gradient effect */
            }
        
            .btn:hover {
                box-shadow: 0 12px 20px 0 rgba(0,0,0,0.2);
            }
        </style>
        
        
      
    </head>
    <body class="antialiased">
        @auth
            <a href="{{ url('/dashboard') }}" class="btn">Inicio</a>
        @else
            <a href="{{ route('login') }}" class="btn">Ingresar</a>

            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn">Registrarse</a>
            @endif
        @endauth
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
           
            </div>
        </div>
    </body>
</html>






