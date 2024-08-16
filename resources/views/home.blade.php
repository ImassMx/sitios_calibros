
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
            <li><a href="/contacto">Contactenos</a></li>
        </ul>
        <div id="hamburguer">
            <button>
                <span class="top-line"></span>
                <span class="middle-line"></span>
                <span class="bottom-line"></span>
            </button>
        </div>
    </nav>
   <main>
       <div class="texto">

        <h1 class="titulo">Nos preocupamos por ti</h1>
        <p class="sub-titulo">Por eso te recomendamos estos libros para que cuides tu salud.</p>
        <a href="{{route('login.cliente')}}" class="descarga">Descargar</a>
       </div>
       <div class="imagen">
            <img src="{{asset('img/undraw_doctor_kw-5-l (1).svg')}}" alt="">
       </div>
   </main> 
    <script src="{{asset('js/index.js')}}"></script>
</body>

</html>