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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="menu">
        <img src="{{ asset('img/logo_ascobereta.jpg') }}" alt="" class="logo">
        <ul class="menu_items">
            @auth
           <form method="POST" action="{{route('logout.cliente')}}">
                @csrf
                <button type="submit"  class="logout">Cerrar Session</button>
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

    <div class="descargas container">
        <div class="content-descargas">
            @if ($libro->estado === 1)
                <h2>{{ $libro->nombre }}</h2>
            <div class="cuerpo-descargas">
                <div class="image">
                    <img src="{{ asset('/admin/portada/' . $libro->portada) }}" alt="">
                </div>
                <div class="descripcion">
                    <p>{{ $libro->descripcion }}</p>

                    <a href="{{ asset('libros/' . $libro->pdf) }}" id="descargar-libro"
                        download="{{ $libro->nombre . '.pdf' }}">Descargar</a>
                    <input type="hidden" value="{{ $libro->descargas }}" id="numerodescarga">
                    <input type="hidden" value="{{auth()->user()->id}}" id="id_usuario">
                    <input type="hidden" value="{{ $libro->id }}" id="id_libro">
                </div>
            </div>
            @else
                <h2>El contenido ya no esta disponible</h2>
            @endif
            <hr>
        </div>
        {{-- <div id="app">

            <zona-descarga />
        </div> --}}
    </div>
    <script src="{{ asset('js/index.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
      <script src="{{ asset('js/libros.js') }}"></script>

    <style>
        .logout{
            background:rgba(0,0,0,0);
            border:none;
            font-size:1rem;
        }
    </style>
</body>

</html>
