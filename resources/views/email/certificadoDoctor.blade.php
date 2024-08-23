<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Certificado</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style>
    @page {
        /*margin-left: 0;*/
        /*margin-right: 0;*/
        margin: 0 !important;
    }

    * {
        font-family: Helvetica;
        font-size: 12px !important;
    }

    body {
        font-size: 12px !important;
        font-weight: 400 !important;
        color: #000 !important;
        text-transform: uppercase;
    }

    .hoja1 {
        background-image: url('img/certificado/Certificado_frontal.jpg');
        background-repeat: no-repeat;
        background-position: center top;
        top: 0;
        left: 0;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        min-width: 816px;
        max-width: 816px;
        min-height: 585px;
        max-height: 585px;
    }

    .hoja2 {
        background-image: url('img/certificado/Certificado_trasera.jpg');
        background-repeat: no-repeat;
        background-position: center top;
        top: 0;
        left: 0;
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        min-width: 816px;
        max-width: 816px;
        min-height: 585px;
        max-height: 585px;
    }


    .texto {
        position: absolute !important;
        text-transform: none;
        font-size: 18px;
        letter-spacing: 0.4pt;
        text-align: center;
        width: 393px;
    }
    </style>

</head>

<body>
    <div class="hoja1">
        <span class="texto" style="margin-top: 240px; margin-left: 233px; position: absolute;">{{ strtoupper($doctor->nombres .' ' .$doctor->apellidos )}}</span>
        <span class="texto" style="margin-top: 320px; margin-left: 233px; position: absolute;">{{strtoupper($book)}}</span>
        <span style="margin-top: 430px; margin-left: 270px; position: absolute;">{{$fecha}}</span>
    </div>
    <div style="page-break-before:always"></div>
    <div class="hoja2"></div>
</body>

</html>