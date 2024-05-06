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
    body {
        font-family: 'Roboto', sans-serif;

    }

    .contenido-email {
        width: 60%;
        border: 2px solid #056743;
        border-radius: 10px;
        display: flex;
        justify-content: center;
        flex-direction: column;
        padding: 2rem 2rem;
        margin: 0 auto;
    }

    .logo-email {
        width: 30%;
        margin: 0 auto;
    }

    .contenido-email h3 {
        text-align: center;
    }


    @media (max-width:768px) {
        .contenido-email {
            width: 90%;
        }

        .logo-email {
            width: 40%;
        }

        .contenido-email h3 {
            text-align: center;
        }

        .contenido-email p {
            text-align: center
        }
    }

    @media (max-width:600px) {
        .contenido-email {
            width: 70%;
        }

        .logo-email {
            width: 40%;
        }

        .contenido-email h3 {
            text-align: center;
        }

        .contenido-email p {
            text-align: center
        }
    }

    img {
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
</style>

<body>
    <img src="https://app-legalhelp.s3.amazonaws.com/ca_libros/bienvenida.jpeg" alt="Bienvenida" style="max-width:100%;">
    <div class="contenido-email">
        <h4>Su número de Folio es : <b>{{ $folio }}</b></h4>
        <p>Gracias por ser parte de Visto Bueno Editores</p>
        <p>Ingresa a esta liga <a href="{{ url('/login/doctor?folio=' . $folio) }} ">{{ $dominio }}</a> para poder iniciar sesión.</p>
    </div>

</body>

</html>
