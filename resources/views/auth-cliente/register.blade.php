<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros Online</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="menu">
        <img src="{{ asset('img/logo_ascobereta.jpg') }}" alt="" class="logo">
        <ul class="menu_items">
            <li><a href="#pro">¿Quienes Somos?</a></li>
            <li><a href="#contact">Contactenos</a></li>
        </ul>
        <div id="hamburguer">
            <button>
                <span class="top-line"></span>
                <span class="middle-line"></span>
                <span class="bottom-line"></span>
            </button>
        </div>
    </nav>
    <div class="registro">
        <h1>Registrate para poder descargar los libros</h1>

        <form action="{{route('cliente.registrar')}}" method="POST">
        @if (session('mensaje'))
        <div class="alert" role="alert">
            {{ session('mensaje') }}
        </div>
                @endif
        @csrf
        <div>
            <label for="apellidoM">Folio del médico</label>
            <input type="text" placeholder="Ingrese el N° de folio" id="folio_doctor" name="folio" value="{{old('folio')}}" />
            @error('folio')
                <p class="error">{{$message}}</p>
            @enderror
        </div>
            <div>
                <label for="nombre">Nombre Doctor</label>
                <input type="text" placeholder="Ingresa el nombre de su doctor" id="nombre_doctor" name="nombre_doctor" value="{{old('nombre_doctor')}}"/>
                @error('nombre_doctor')
                    <p class="error">{{$message}}</p>
                @enderror
            </div>
            <div>
                <label for="apellidoP">Nombre Paciente </label>
                <input type="text" placeholder="Ingrese su nombre" id="apellidoP" name="nombre_paciente" value="{{old('nombre_paciente')}}" />
                @error('nombre_paciente')
                    <p class="error">{{$message}}</p>
                @enderror
            </div>
            
            <div>
                <label for="email">Email</label>
                <input type="email" placeholder="Ingresa tu email" id="email" name="email" value="{{old('email')}}" />
                @error('email')
                    <p class="error">{{$message}}</p>
                @enderror
            </div>
            <div>
                <label for="celular">Celular</label>
                <input type="text" placeholder="Ingresa tu numero de celular" id="celular" name="celular" value="{{old('celular')}}" />
                @error('celular')
                    <p class="error">{{$message}}</p>
                @enderror
            </div>
            <div>
                <label for="celular">Código Postal</label>
                <input type="text" placeholder="Ingrese el código postal" id="codigo_postal" name="codigo" value="{{old('codigo')}}" />
                @error('codigo')
                    <p class="error">{{$message}}</p>
                @enderror
            </div>
            <div>
                <label for="celular">Alcaldia/Municipio</label>
                <input type="text" placeholder="Ingrese el código postal" id="alcaldia"  name="alcaldia" value="{{old('alcaldia')}}" />
                @error('alcaldia')
                    <p class="error">{{$message}}</p>
                @enderror
            </div>
            <div>
                <label for="celular">Ciudad</label>
                <input type="text" placeholder="Ingrese el código postal" id="ciudad"  name="ciudad" value="{{old('ciudad')}}"/>
                @error('ciudad')
                    <p class="error">{{$message}}</p>
                @enderror
            </div>
            <div>
                <label for="celular">Estado</label>
                <input type="text" placeholder="Ingrese el código postal" id="estado" name="estado" value="{{old('estado')}}" />
                @error('estado')
                    <p class="error">{{$message}}</p>
                @enderror
            </div>
            <input type="hidden" value="12345" name="password">
            <input type="submit" value="Registrarse" class="registrar" />
        </form>
    </div>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/index.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
     <script src="{{ asset('js/buscador.js') }}"></script>
     <script src="{{ asset('js/BuscadorFolio.js') }}"></script>
     <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</body>

</html>
