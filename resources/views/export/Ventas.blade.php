
<table style="width:100%">
</table>

<h3>Reporte de Ventas</h3>
<table style="width:100%">

</table>

<table>
    <thead>
        <tr>
            <th style="text-align: center;font-weight:bold;">CONTRASEÑA LIBRO</th>
            <th style="text-align: center;font-weight:bold;">CANTIDAD COMPRADA</th>
            <th style="text-align: center;font-weight:bold;">COSTO UNITARIO</th>
            <th style="text-align: center;font-weight:bold;">IMPORTE PAGADO</th>
            <th style="text-align: center;font-weight:bold;">FECHA COMPRA</th>
            <th style="text-align: center;font-weight:bold;">FÓLIO MEDICO</th>
            <th style="text-align: center;font-weight:bold;">NOMBRES APELLIDOS</th>
            <th style="text-align: center;font-weight:bold;">CÓDIGO POSTAL</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($books as $book)
            <tr>
                <td>{{ $book->book->password }}</td>
                <td>1</td>
                <td>{{ $book->book->price  }}</td>
                <td>{{ $book->book->price }}</td>
                <td>
                    {{ Carbon\Carbon::parse($book->created_at)->format('m-d-Y H:i:s')}}
                </td>
                <td>
                    {{  $book->doctor->folio}}
                </td>
                <td>
                    {{  $book->doctor->nombres }} {{$book->doctor->apellidos}}
                </td>
                <td>
                    {{  $book->doctor->cp }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
