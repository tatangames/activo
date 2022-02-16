<html>
<head>
    <meta charset="UTF-8" />
    <title>Alcaldía Metapán | Reporte</title>

    <style>


    </style>
</head>
<body>
<div id="header">
    <div class="content">
        <img src="{{ asset('images/logo2.png') }}" style="float: right" alt="" height="88px" width="71px">
        <img src="{{ asset('images/elsalvador.png') }}" style="float: left" alt="" height="88px" width="86px">
        <p style="text-align: center; font-size: 25px; font-weight: bold;">UNIDAD DE INVENTARIO Y ACTIVO FIJO <br>
            REPORTE DE INVENTARIO <br> ________________________________</p>
    </div>


</div>

<h2 style="text-align: center; font-size: 19px">Descargos realizados desde: {{ $f1 }} hasta {{ $f2 }} <br> <br> Bienes Vehículos y Maquinaria </h2>
@if($haydatos == false)
    <p style="margin-left: 60px; font-size: 18px">No hay Registros en el periodo especificado </p>
@else

    <div id="content">
        <table id="tabla" style="table-layout:fixed;">
            <thead>
            <tr>
                <th style="text-align: center; color: black; font-size:15px; width: 12%">Código</th>
                <th style="text-align: center; color: black; font-size:15px; width: 20%">Descripción</th>
                <th style="text-align: center; color: black; font-size:15px; width: 11%">Fecha Descargo</th>
                <th style="text-align: center; color: black; font-size:15px; width: 11%">Valor</th>
            </tr>
            </thead>

            @foreach($lista as $item)
                <tr>
                    <td style="text-align: center">{{ $item->codigo }}</td>
                    <td style="text-align: left">{{ $item->descripcion }}</td>
                    <td style="text-align: center">{{ $item->fecha }}</td>
                    <td style="text-align: center">{{ $item->valor }}</td>
                </tr>

            @endforeach

        </table>
    </div>

    <div class="firma">
        <p>
            _________________________________<br>
            &nbsp;&nbsp;&nbsp;Lic Esmeralda Rodriguez de Contreras<br>
            &nbsp;&nbsp;&nbsp;&nbsp;Encargada de Inventario y Activo fijo
        </p>
    </div>


@endif


</body>
</html>
