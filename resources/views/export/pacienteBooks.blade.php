<table style="width:100%">
</table>

<h3>Reporte de Libros Pacientes</h3>
<table style="width:100%">

</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center;font-weight:bold;">CONTRASEÑA LIBRO</th>
            <th style="text-align: center;font-weight:bold;">NOMBRE LIBRO</th>
            <th style="text-align: center;font-weight:bold;">CÓDIGO</th>
            <th style="text-align: center;font-weight:bold;">NOMBRES Y APELLIDOS</th>
            <th style="text-align: center;font-weight:bold;">CÓDIGO POSTAL</th>
            <th style="text-align: center;font-weight:bold;">ALCALDIA</th>
            <th style="text-align: center;font-weight:bold;">CIUDAD</th>
            <th style="text-align: center;font-weight:bold;">FECHA DESCARGA</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($books as $book)
            <tr>
                <td>{{ $book->book->password }}</td>
                <td>{{ $book->book->name }}</td>
                <td>{{ $book->doctor->folio }}</td>
                <td>{{ $book->client->user->name }}</td>
                <td>{{ $book->client->codigo_postal }}</td>
                <td>{{ $book->client->sepomex ? $book->client->sepomex->d_mnpio : '' }}</td>
                <td>{{ $book->client->sepomex ? $book->client->sepomex->d_ciudad : '' }}</td>
                <td>{{ Carbon\Carbon::parse($book->created_at)->format('d-m-Y H:i:s') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
