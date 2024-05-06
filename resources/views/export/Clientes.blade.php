
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
            <th style="text-align: center;font-weight:bold;">FECHA REGISTRO</th>
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
                <td>
                    {{ $date::parse($cliente->created_at)->format('d-m-Y') }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
