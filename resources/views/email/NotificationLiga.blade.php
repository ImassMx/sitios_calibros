<!DOCTYPE html>
<html lang="es">
<html>

<head>
    <style>
        /* Estilos en línea para correos electrónicos */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
        }

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 24px;
            background-color: #ffffff;
            box-shadow: -1px 1px 16px 3px rgba(0, 0, 0, 0.48);
            -webkit-box-shadow: -1px 1px 16px 3px rgba(0, 0, 0, 0.48);
            -moz-box-shadow: -1px 1px 16px 3px rgba(0, 0, 0, 0.48);
        }

        .header {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .main {
            text-align: center;
        }

        .main h2 {
            color: #374151;
            font-size: 1.75rem;
        }

        .main p {
            margin-top: 8px;
            line-height: 1.6;
            color: #666;
            font-size: 1rem;
        }

        .button {
            padding: 12px 30px;
            background-color: #5D025F;
            color: #ffffff !important;
            border: none;
            border-radius: 4px;
            text-transform: uppercase;
            text-decoration: none;
            font-size: .8rem;
            margin-top: 1rem;
            margin-bottom: 1rem;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .button:hover {
            background-color: #5D025F;
        }

        .footer {
            margin-top: 16px;
            color: #777;
            font-size: 0.9rem;
        }

        @media (max-width:768px) {
            h2 {
                font-size: .7rem;
            }
        }
    </style>
</head>

<body>
    <div class="container" style="box-shadow: -1px 1px 16px 3px rgba(0, 0, 0, 0.48);">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center" valign="middle">
                    <img src="https://www.vistobuenoeditores.com.mx/wp-content/uploads/2022/09/Logo-Inicio-1.png"
                        alt="Descripción de la imagen" width="200px" height="200px">
                </td>
            </tr>
        </table>

        <div class="main" style="margin-top: 3rem !important;margin-bottom:3rem !important;">
            <p style="margin-bottom: 3rem;">{{ $mensaje }}</p>
            <a class="button" href="{{$url}}" style="cursor: pointer !important;margin-top:3rem">Ir a la Liga</a>
        </div>
        <div class="footer">
            <p>Para mayor información , términos y condiciones,aviso de privacidad acceder a:
                <a href="https://www.vistobuenoeditores.com.mx/"
                    style="color: #007bff; text-decoration: none;">www.vistobuenoeditores.com.mx</a>.<br>
            </p>
            <p class="mt-3">© {{ date('Y') }} Visto Bueno Editores. Todos los derechos reservados.</p>
        </div>
    </div>
</body>

</html>
