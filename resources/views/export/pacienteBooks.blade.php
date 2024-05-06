<table style="width:100%">
</table>

<h3>Reporte de Libros Pacientes</h3>
<table style="width:100%">

</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center;font-weight:bold;">ID</th>
            <th style="text-align: center;font-weight:bold;">PACIENTE</th>
            <th style="text-align: center;font-weight:bold;">DOCTOR</th>
            <th style="text-align: center;font-weight:bold;">LIBRO</th>
            <th style="text-align: center;font-weight:bold;">DESCARGAS</th>
            <th style="text-align: center;font-weight:bold;">ULT. DESCARGA</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($books as $book)
            <tr>
                <td>{{ $book->id }}</td>
                <td>{{ $book->client->name }}</td>
                <td>{{ $book->doctor->nombres }} {{ $book->doctor->apellidos }}</td>
                <td>{{ $book->book->name }}</td>
                <td>{{ $book->donwloads }}</td>
                <td>
                    {{ Carbon\Carbon::parse($book->updated_at)->format('d-m-Y H:i:s') }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
