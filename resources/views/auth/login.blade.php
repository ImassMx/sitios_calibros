<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

</head>

<body>

    <main class="login">
        @if (session('mensaje'))
            <div class="alert alert-success" role="alert">
                <p class="error">{{ session('mensaje') }}</p>
            </div>
        @endif
        <div class="contenido">
            <img src="{{asset('img/logo.jpg')}}" alt="">
            <div class="body-login">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="inputs">
                        <label for="">Usuario</label>
                        <input type="text" placeholder="Ingresa tu usuario" name="email" value="{{old('email') }}">
                        @error('email')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="inputs">
                        <label for="">Contraseña</label>
                        <input type="password" placeholder="Ingresa tu contraseña" name="password">
                        @error('password')
                            <p class="error">{{ $message }}</p>
                        @enderror
                    </div>
                    <input type="submit" value="INGRESAR" class="ingresar">
                </form>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/index.js') }}"></script>
</body>

</html>
