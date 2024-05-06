<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libros Online</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <nav class="menu">
        <img src="{{asset('img/logo.jpg')}}" alt="" class="logo">
        <ul class="menu_items">
            <li><a href="#pro">¿Quienes Somos?</a></li>
            <li><a href="/marketplace">Marketplace</a></li>
            <li><a href="/contacto">Contactenos</a></li>
            <li><a href="/marketplace/carrito" class="p-2 fw-bold backg-p text-white" style="border-radius:26px">
                    <img src="{{asset('/img/shop-b.svg')}}" alt="buscar" width="26">
                    <span>3</span>
                </a></li>
        </ul>
        <div id="hamburguer">
            <button>
                <span class="top-line"></span>
                <span class="middle-line"></span>
                <span class="bottom-line"></span>
            </button>
        </div>
    </nav>
    <div class="container bg-white mt-3">
        <div class="row pt-3 justify-content-center">
            <div class="col-md-12 col-sm-12">
                <h1><img src="{{asset('/img/book.svg')}}" alt="buscar" width="50"> Mis libros</h1>
            </div>
            <div class="col-md-9 col-sm-12 pt-3">
                <table class="table">
                    <tbody>
                        <tr>
                            <td width="90px">
                                <img src="/libros/caratulas/libro1.jpg" class="img-fluid rounded" alt="Libro"
                                    style="max-width:90px">
                            </td>
                            <td>
                                <h5 class="fw-bold">Psicología médica y comunicación</h5>
                                <p class="fw-bold text-muted m-0 p-0">AUTOR</small>
                                <p class="text-muted m-0 p-0">Categoria: Lorem</p>
                            </td>
                            <td class="fw-bold color-s">50 puntos</td>
                            <td>
                                <img src="/img/download.svg" class="img-fluid  mx-auto d-block" alt="Eliminar"
                                    style="width:60px">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <script src="{{asset('js/index.js')}}"></script>
</body>

</html>