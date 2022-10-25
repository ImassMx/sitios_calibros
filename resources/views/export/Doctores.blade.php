
<table style="width:100%">
</table>

<h3>Reporte de Doctores</h3>
<table style="width:100%">

</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center;font-weight:bold;">ID</th>
            <th style="text-align: center;font-weight:bold;">NOMBRE</th>
            <th style="text-align: center;font-weight:bold;">APELLIDOS</th>
            <th style="text-align: center;font-weight:bold;">ESPECIALIDAD</th>
            <th style="text-align: center;font-weight:bold;">FOLIO</th>
            <th style="text-align: center;font-weight:bold;">LIGA</th>
            <th style="text-align: center;font-weight:bold;">CÓDIGO POSTAL</th>
            <th style="text-align: center;font-weight:bold;">FECHA DESCARGA</th>
            <th style="text-align: center;font-weight:bold;">DESCARGAS</th>
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
                <td>
                    {{$doctor->descargas}}
                </td>
        </tr>
         @endforeach
    </tbody>
</table>
