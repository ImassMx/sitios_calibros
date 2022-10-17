<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>APELLIDOS</th>
            <th>ESPECIALIDAD</th>
            <th>FOLIO</th>
            <th>LIGA</th>
            <th>CÓDIGO POSTAL</th>
            <th>FECHA DESCARGA</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($doctores as $doctor)
        <tr>
                <td>{{ $doctor->id }}</td>
                <td>{{ $doctor->nombres }}</td>
                <td>{{ $doctor->apellidos }}</td>
                <td>
                    {{ $doctor->especialidad->nombre }}
                </td>
                <td>{{$doctor->folio}}</td>
                <td>
                    {{ $doctor->ligas->nombre }}
                </td>
                <td>
                    {{ $doctor->cp }}
                </td>
                <td>
                    {{ $date::parse($doctor->fecha_descarga)->format('d-m-Y') }}
                </td>
        </tr>
         @endforeach
    </tbody>
</table>
