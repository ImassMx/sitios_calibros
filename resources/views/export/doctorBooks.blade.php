<table style="width:100%">
</table>

<h3>Reporte de Libros Doctores</h3>
<table style="width:100%">

</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center;font-weight:bold;">PASSWORD</th>
            <th style="text-align: center;font-weight:bold;">NOMBRES Y APELLIDOS</th>
            <th style="text-align: center;font-weight:bold;">CÓDIGO MÉDICO</th>
            <th style="text-align: center;font-weight:bold;">ESPECIALIDAD</th>
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
                <td>{{ $book->user->name }}</td>
                <td>{{ $book->user->doctorReport->folio }}</td>
                <td>{{ $book->user->doctorReport->especialidad->nombre }}</td>
                <td>{{ $book->user->doctorReport->cp }}</td>
                <td>{{ $book->user->doctorReport->sepomex->d_mnpio ?? '' }}</td>
                <td>{{ $book->user->doctorReport->sepomex->d_ciudad ?? '' }}</td>
                <td>{{ Carbon\Carbon::parse($book->created_at)->format('d-m-Y H:i:s') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
