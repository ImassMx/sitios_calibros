<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros Online</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<style>
.link-register {
    font-size: 15px;
    margin-top: 20px !important;
    margin-bottom: 10px;
    color: rgba(0, 0, 0, 0.55);
}

.label-link-register {
    margin: 0px !important;
}
</style>

<body>
    <nav class="menu">
        <img src="{{asset('img/logo.jpg')}}" alt="" class="logo">
        <ul class="menu_items">
            <li><a href="/">¿Quienes Somos?</a></li>
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
    <section>
        <div class="container pt-md-5">
            <div class="row justify-content-center">
                <div class="col-md-5 col-sm-12 m-md-4">
                    <div class="card  p-3 rounded" style="box-shadow: 0px 5px 11px 3px rgba(186,182,186,1);">
                        <div class="login">
                            <h1 class="text-center">Bienvenido Doctor(a)</h1>
                            <form action="{{route('login.zona.doctor')}}" method="POST">
                                @csrf
                                <div class="form-row justify-content-center">
                                    <div class="form-group col-md-12 col-sm-12 text-center">
                                        <h5>Ingrese los datos para ingresar</h5>
                                    </div>
                                    <div class="form-group col-md-8 col-sm-12 pt-md-4">
                                        <label for="celular">Código de acceso</label>
                                        <input type="password" placeholder="00000" id="folio" name="folio"
                                            class="form-control" maxlength="5">
                                        @if (session('mensaje'))
                                        <div class="alert alert-warning" role="alert">
                                            {{ session('mensaje') }}
                                        </div>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-8 col-sm-12 pt-2">
                                        <input type="submit" class="btn btn-success w-100 mt-3 mb-2" value="Ingresar">
                                        <p class="label-link-register text-center">
                                            No tengo una cuenta <br><a href="/registrar/doctor"
                                                class="link-register">¡Registrarme
                                                ahora!</a></p>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <script src="{{asset('js/index.js')}}"></script>
    <script src="{{asset('js/doctor.js')}}"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
</body>

</html>