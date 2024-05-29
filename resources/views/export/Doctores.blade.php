<table style="width:100%">
</table>

<h3>Reporte de médicos</h3>
<table style="width:100%">

</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center;font-weight:bold;">FOLIO</th>
            <th style="text-align: center;font-weight:bold;">NOMBRE</th>
            <th style="text-align: center;font-weight:bold;">APELLIDOS</th>
            <th style="text-align: center;font-weight:bold;">ESPECIALIDAD</th>
            <th style="text-align: center;font-weight:bold;">EMAIL</th>
            <th style="text-align: center;font-weight:bold;">TELEFONO</th>
            <th style="text-align: center;font-weight:bold;">CÓDIGO POSTAL</th>
            <th style="text-align: center;font-weight:bold;">ALCALDIA</th>
            <th style="text-align: center;font-weight:bold;">CIUDAD</th>

        </tr>
    </thead>
    <tbody>
        @foreach ($doctores as $doctor)
            <tr>
                <td>{{ $doctor->folio }}</td>
                <td>{{ $doctor->nombres }}</td>
                <td>{{ $doctor->apellidos }}</td>
                <td>
                    {{ $doctor->especialidad->nombre }}
                </td>
                <td>{{ $doctor->user->email }}</td>
                <td>{{ $doctor->user->celular }}</td>
                <td>
                    {{ $doctor->cp }}
                </td>
                <td>{{ $doctor->sepomex->d_mnpio ?? '' }}</td>
                <td>{{ $doctor->sepomex->d_ciudad ?? '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
