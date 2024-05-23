<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros Online</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
    <style>
        .link-register{
            font-size: 15px;
            margin-top: 20px !important;
            margin-bottom: 10px;
            color: rgba(0, 0, 0, 0.55);
        }
        .label-link-register{
            margin: 0px !important;
        }
    </style>
<body>
    <nav class="menu">
        <img src="{{asset('img/logo.jpg')}}" alt="" class="logo">
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

    <div class="content-login">
        
        <div class="login">
            <h1 style="text-align: center;color:white">Bienvenido</h1>
        @if (session('mensaje'))
                    <div class="alert alert-success" role="alert">
                        {{ session('mensaje') }}
                    </div>
                @endif
            <form action="{{route('login.zona.doctor')}}" method="POST">
            @csrf
                <label for="celular">Ingrese su Código de Registro</label>
                <input type="text" placeholder="Ingrese el código de registro" id="folio" name="folio">
                <label for="" class="label-link-register"><a href="/registrar/doctor" class="link-register">Registrate aquí.</a></label>
                <input type="submit" class="ingresar" value="Ingresar" style="margin-top: 15px;">
            </form>
        </div>
    </div>
    
    <script src="{{asset('js/index.js')}}"></script>
    <script src="{{asset('js/doctor.js')}}"></script>
</body>

</html>
