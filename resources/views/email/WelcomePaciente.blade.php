<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
</head>
    
<style>
    body{
        font-family: 'Roboto', sans-serif;

    }
    .contenido-email{
        width: 60%;
        border: 2px solid #056743;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        flex-direction: column;
        padding:2rem 2rem; 
        margin: 0 auto;
    }
    .logo-email{
        width: 30%;
        margin: 0 auto;
    }
    .contenido-email h3{
        text-align: center;
    }

   
    @media (max-width:768px)
    {
        .contenido-email{
            width: 90%;
        }
        .logo-email{
        width: 40%;
        }
        .contenido-email h3{
        text-align: center;
    }
    .contenido-email p{
        text-align: center
    }
    }

    @media (max-width:600px)
    {
        .contenido-email{
            width: 70%;
        }
        .logo-email{
        width: 40%;
        }
        .contenido-email h3{
        text-align: center;
        }
        .contenido-email p{
        text-align: center
    }
    }
</style>

<body>

    <div class="contenido-email">
        <img src="{{asset("img/logo.jpg")}}" alt="" class="logo-email">
        <h3>Gracias por ser parte de Visto Bueno Editores</h3>
        <p>Ingresa a esta liga <a href="{{$dominio}}'/registrar/cliente'">{{$dominio}}</a> para descargar el libro con el codigo {{$folio}}.</p>
    </div>

</body>
</html>