<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>APELLIDOS</th>
            <th>ESPECIALIDAD</th>
            <th>FOLIO</th>
            <th>LIGA</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($doctores as $doctor)
        <tr>
                <td>{{ $doctor->id }}</td>
                <td>{{ $doctor->nombre }}</td>
                <td>{{ $doctor->apellidos }}</td>
                <td>
                    {{ $doctor->especialidad->nombre }}
                </td>
                <td>{{$doctor->folio}}</td>
                <td>
                    {{ $doctor->ligas->nombre }}
                </td>
        </tr>
         @endforeach
    </tbody>
</table>
