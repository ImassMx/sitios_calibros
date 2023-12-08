<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form</title>
</head>
<body>
    <h1>Datos Formulario</h1>
    <p>Nombre: {{$data['nombre']}}</p>
    <p>Email: {{$data['email']}}</p>
    <p>Desea más información: {{$data['informacion'] == 'on'?'Si':'No'}}</p>

</body>
</html>