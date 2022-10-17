<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE PACIENTE</th>
            <th>FOLIO</th>
            <th>CELULAR</th>
            <th>CODIGO POSTAL</th>
            <th>ALCALDIA</th>
            <th>ESTADO</th>
            <th>LIBRO</th>
            <th>FECHA REGISTRO</th>
            <th>FECHA DESCARGA</th>
            <th>DESCARGAS</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($clientes as $cliente)
        <tr>
                <td>{{ $cliente->user->id }}</td>
                <td>{{ $cliente->user->name }}</td>
                <td>{{ $cliente->folio }}</td>
                <td>{{ $cliente->user->celular }}</td>
                <td>
                    {{ $cliente->codigo_postal }}
                </td>
                <td>{{$cliente->alcaldia}}</td>
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
                    {{ $date::parse( $cliente->created_at)->format('d-m-Y') }}
                </td>
                <td>
                    {{ $date::parse($cliente->fecha_descarga)->format('d-m-Y')}}
                </td>
                <td>
                    {{ $cliente->descargas}}
                </td>
        </tr>
         @endforeach
    </tbody>
</table>
