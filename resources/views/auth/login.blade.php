<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros Online</title>
    <link rel="stylesheet" href="{{ asset('css/estilos.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

</head>

<body>

    <main class="login">
        <div class="container pt-md-5">
            <div class="row justify-content-center">
                <div class="col-md-5 col-sm-12 m-md-4">
                    <div class="card p-3 rounded" style="box-shadow: 0px 5px 11px 3px rgba(186,182,186,1);">

                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-row justify-content-center pt-3">
                                <div class="form-group col-md-8 col-sm-12 text-center">
                                    <img src="{{asset('img/logo.jpg')}}" alt="Logo" class="img-fluid mb-4" width="250">
                                    @if (session('mensaje'))
                                    <div class="alert alert-success" role="alert">
                                        <p class="error">{{ session('mensaje') }}</p>
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group col-md-8 col-sm-12 text-left">
                                    <div class="inputs">
                                        <label for="">Usuario</label>
                                        <input class="form-control" type="text" placeholder="Ingresa tu usuario"
                                            name="email" value="{{old('email') }}">
                                        @error('email')
                                        <p class="error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-md-8 col-sm-12 text-left">
                                    <div class="inputs">
                                        <label for="">Contraseña</label>
                                        <input type="password" placeholder="Ingresa tu contraseña" name="password"
                                            class="form-control">
                                        @error('password')
                                        <p class="error">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-md-8 col-sm-12 pt-2 text-center">
                                    <input type="submit" value="Ingresar" class="ingresar"
                                        class="btn btn-success w-100 mt-3 mb-2">
                                </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/index.js') }}"></script>
</body>

</html>