<table style="width:100%">
</table>

<h3>Reporte de Pacientes</h3>
<table style="width:100%">

</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center;font-weight:bold;">FOLIO MÉDICO</th>
            <th style="text-align: center;font-weight:bold;">NOMBRE COMPLETO</th>
            <th style="text-align: center;font-weight:bold;">EMAIL</th>
            <th style="text-align: center;font-weight:bold;">CELULAR</th>
            <th style="text-align: center;font-weight:bold;">CODIGO POSTAL</th>
            <th style="text-align: center;font-weight:bold;">ALCALDIA</th>
            <th style="text-align: center;font-weight:bold;">CIUDAD</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($clientes as $cliente)
        <tr>
            <td>{{ $cliente->folio }}</td>
            <td>{{ $cliente->user->name }}</td>
            <td>{{ $cliente->user->email }}</td>
            <td>{{ $cliente->user->celular }}</td>
            <td>
                {{ $cliente->codigo_postal }}
            </td>
            <td>
                {{  $cliente->sepomex->d_mnpio ?? ''}}
            </td>
            <td>
                {{  $cliente->sepomex->d_ciudad ?? ''}}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>