
<table style="width:100%">
</table>

<h3>Reporte de Pacientes</h3>
<table style="width:100%">

</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center;font-weight:bold;">ID</th>
            <th style="text-align: center;font-weight:bold;">NOMBRE PACIENTE</th>
            <th style="text-align: center;font-weight:bold;">FOLIO</th>
            <th style="text-align: center;font-weight:bold;">CELULAR</th>
            <th style="text-align: center;font-weight:bold;">CODIGO POSTAL</th>
            <th style="text-align: center;font-weight:bold;">ALCALDIA</th>
            <th style="text-align: center;font-weight:bold;">ESTADO</th>
            <th style="text-align: center;font-weight:bold;">LIBRO</th>
            <th style="text-align: center;font-weight:bold;">FECHA REGISTRO</th>
            <th style="text-align: center;font-weight:bold;">FECHA DESCARGA</th>
            <th style="text-align: center;font-weight:bold;">DESCARGAS</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clientes as $cliente)
            <tr>
                <td>{{ $cliente->id }}</td>
                <td>{{ $cliente->user->name }}</td>
                <td>{{ $cliente->folio }}</td>
                <td>{{ $cliente->user->celular }}</td>
                <td>
                    {{ $cliente->codigo_postal }}
                </td>
                <td>{{ $cliente->alcaldia }}</td>
                <td>
                    {{ $cliente->estado }}
                </td>

                @if ($cliente->libro_id)
                    @foreach ($cliente->libro as $libro)
                        <td> {{ $libro->nombre }}</td>
                    @endforeach
                @else
                    <td></td>
                @endif

                <td>
                    {{ $date::parse($cliente->created_at)->format('d-m-Y') }}
                </td>
                <td>
                    {{ $date::parse($cliente->fecha_descarga)->format('d-m-Y') }}
                </td>
                <td>
                    {{ $cliente->descargas }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
