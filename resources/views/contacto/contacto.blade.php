<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Libros Online</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{asset("css/contacto.css")}}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body>
    <nav class="menu">
        <a href="/"><img src="{{ asset('img/logo.jpg') }}" alt="" class="ml-6 md:w-[90px] w-[80px]"></a>
        <ul class="menu_items">
            @auth
                <form method="POST" action="{{ route('logout.cliente') }}">
                    @csrf
                    <button type="submit" class="logout">Cerrar Session</button>
                </form>
            @endauth
            @guest
                <li><a href="#pro">¿Quienes Somos?</a></li>
                <li><a href="#contact">Contactenos</a></li>
            @endguest
        </ul>
        <div id="hamburguer">
            <button>
                <span class="top-line"></span>
                <span class="middle-line"></span>
                <span class="bottom-line"></span>
            </button>
        </div>
    </nav>
    <div class="bg-gray-100 flex items-center justify-center h-screen p-4">
        <div class="bg-white p-8 rounded-lg shadow-lg max-w-sm w-full">
            @if (session('mensaje'))
            <div id="mensaje" class="font-regular relative mb-4 block w-full rounded-lg bg-green-500 p-4 text-base leading-5 text-white opacity-100 text-center">{{session('mensaje')}}</div>
            @endif
            <h2 class="text-xl font-semibold text-center mb-4 md:text-2xl">Formulario de Contacto</h2>
            <form  method="POST" action="{{route('send.email')}}">
                @csrf
                <div class="mb-4">
                    <label for="fullName" class="block text-gray-700 text-sm font-semibold mb-2">Nombre</label>
                    <input type="text" id="fullName" class="form-input w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-blue-500" required placeholder="Nombre Completo" name="nombre">
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-semibold mb-2">Correo Electrónico</label>
                    <input type="email" id="email" class="form-input w-full px-4 py-2 border rounded-lg text-gray-700 focus:ring-blue-500" required placeholder="Email de contacto" name="email">
                </div>
                <div class="mb-3 flex flex-row content-center my-4">
                    <input  type="checkbox" class="mr-1 checked:bg-purple-700" required name="informacion" /> <label for="remember" class="mr-auto md:text-[14px] font-semibold text-[12px]">Deseo recibir más información del producto.</label>
                  </div>
                <button type="submit" class="w-full bg-[#5F055F] text-white px-4 py-2 rounded-lg hover:bg-[#623A62] focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Enviar</button>
            </form>
        </div>
    </div>
    <script src="{{ asset('js/index.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var mensaje = document.getElementById('mensaje');
            if (mensaje) {
                setTimeout(function () {
                    mensaje.style.display = 'none';
                }, 5000);
            }
        });
    </script>
    
</body>

</html>
