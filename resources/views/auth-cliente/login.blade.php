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
        @if (session('mensaje'))
                    <div class="alert alert-success" role="alert">
                        {{ session('mensaje') }}
                    </div>
                @endif
            <form action="{{route('post.login')}}" method="POST">
            @csrf
                <label for="celular">Celular</label>
                <input type="text" placeholder="Ingresa tu número de celular" id="celular" name="celular">
                <input type="submit" class="ingresar" value="Ingresar">
            </form>
        </div>
    </div>
    <script src="{{asset('js/index.js')}}"></script>
</body>

</html>
