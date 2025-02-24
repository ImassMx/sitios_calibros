<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros Online</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    @yield('styles')
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
    .logout {
        background: rgba(0, 0, 0, 0);
        border: none;
        font-size: 0.9rem;
        cursor: pointer;
        margin-top: .5rem;
        color: #5D025F;
        font-weight: bold;
    }

    .terminos {
        margin: 0;
    }

    .title {
        text-align: center;
        margin-top: 3rem;
        margin-bottom: 3rem;
    }

    .card-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .card-header {
        padding: 10px;
        background-color: #f0f0f0;
        border-bottom: 1px solid #ddd;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    .card-body {
        padding: 20px;
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
        padding: 10px;
    }

    .btn-email,
    .btn-sms {
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-email:hover,
    .btn-sms:hover {
        background-color: #0056b3;
    }
    </style>

</head>

<body>
    <div class="container-fluid p-1" id="app">
        <nav class="menu">
            <img src="{{ asset('img/logo.jpg') }}" alt="" class="logo">
            <ul class="menu_items">
                @guest
                <li><a href="/contacto">Contactenos</a></li>
                @endguest
                @auth
                <ul class="nav nav-pills">
                    @if (!auth()->user()->hasRole('Cliente'))
                    <show-carrito user="{{ auth()->user()->id }}"></show-carrito>
                    <menu-componente user="{{ auth()->user()->id }}"></menu-componente>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout.doctor') }}">
                            @csrf
                            <button type="submit" class="logout"><img src="/img/exit.svg" alt="buscar"
                                    width="20">Salir</button>
                        </form>
                    </li>
                    @endif
                    @if (auth()->user()->hasRole('Cliente'))
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout.cliente') }}">
                            @csrf
                            <button type="submit" class="logout"><img src="/img/exit.svg" alt="buscar"
                                    width="20">Salir</button>
                        </form>
                    </li>
                    @endif
                </ul>
                @endauth
            </ul>
            <div id="hamburguer">
                <button>
                    <span class="top-line"></span>
                    <span class="middle-line"></span>
                    <span class="bottom-line"></span>
                </button>
            </div>
        </nav>
        <section class="pb-5 mb-5">
            @yield('content-mkt')
        </section>
        @auth
        <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top mt-5">
            <div class="col-md-12 d-flex align-items-center">
                <a href="/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                    <svg class="bi" width="30" height="24">
                        <use xlink:href="#bootstrap" />
                    </svg>
                </a>
                <span class="text-muted">
                    Para mayor información , términos y condiciones, aviso de privacidad acceder a:
                    <a href="https://www.vistobuenoeditores.com.mx">www.vistobuenoeditores.com.mx </a><br>
                    <b>Nota: </b>Por ser libros digitales las devoluciones no aplican</span>
            </div>
        </footer>
        @endauth
    </div>
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="
            https://cdn.jsdelivr.net/npm/conekta-card-tokenizer@1.0.1/dist/conekta.min.js
            "></script>
    <script type="text/javascript" data-conekta-public-key="key_OthEeT6z589uahS2KVKAcMd"
        src="https://cdn.conekta.io/js/v1.0.1/conekta.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/index.js') }}"></script>
    @yield('scripts')
</body>

</html>