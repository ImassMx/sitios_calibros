<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>agradecimiento</title>
</head>
    <style>
        .content-aviso{
            margin-top: 2rem;
        }
    </style>
<body>
    <img src="{{asset('/img/agradecimiento.jpg' )}}" alt="Imagen Agradecimiento" width="100%" height="100%">
    @foreach ($libros as $book)
        <p>Libro : {{$book["name"]}}</p>
        <p>Contraseña: {{$book["password"]}}</p>
        <p>Link: <a href="{{$book["url"]}}">{{$book["name"]}}</a></p>
    @endforeach
    <label for="">Las ligas caducan 3 horas despues de recibido este correo.</label>
    <div class="content-aviso">
        <p>Para facturar, favor de enviar un correo al siguiente email.</p>
        <p><b>facturas@vistobuenoeditoreas.com.mx.</b></p>
        <p>Por disposiciones fiscales, la facturación debe hacerse el mismo mes de la compra</p>
    </div>
</body>

</html>
