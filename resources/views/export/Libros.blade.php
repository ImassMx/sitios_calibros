<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>DESCRIPCION</th>
            <th>ESTADO</th>
            <th>N° DESCARGAS</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($libros as $libro)
        <tr>
                <td>{{ $libro->id }}</td>
                <td>{{ $libro->nombre }}</td>
                <td>{{ $libro->descripcion }}</td>
                <td>
                    {{ $libro->estado }}
                </td>
                <td>
                    {{ $libro->descargas }}
                </td>
        </tr>
         @endforeach
    </tbody>
</table>
