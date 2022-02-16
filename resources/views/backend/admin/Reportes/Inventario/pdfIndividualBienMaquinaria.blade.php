<html>
<head>
    <meta charset="UTF-8" />
    <title>Alcaldía Metapán | Reporte</title>

    <style>
        .firma {
            left: 0;
            font-size: 20px;
            margin-top: 150px;
            margin-left: 20px;
            text-align: left;
            page-break-inside: avoid;
        }

        br[style] {
            display:none;
        }

        thead {
            display: table-row-group;
        }

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

<p style="text-align: center; font-weight: bold; font-size: 19px"> Reporte para el bien con el código: {{$info->codigo}} </p>
<p style="text-align: center; font-weight: bold; font-size: 19px"> Bien Vehículo y Maquinaria </p>

<div style="margin: 25px">

    <p style="font-size: 20px;"><strong>Número de equipo: </strong> {{ $info->codigo }}</p>

    <p style="font-size: 20px;"><strong>Descripción: </strong> {{ $info->descripcion }}</p>

    <p style="font-size: 20px;"><strong>Fecha de Compra: </strong> {{ $fecha }}</p>

    <p style="font-size: 20px;"><strong>Valor total de compra: </strong>$ {{ $info->valor }}</p>

    <p style="font-size: 20px;"><strong>Valor de equipo: </strong>$ {{ $info->valor }}</p>

    <p style="font-size: 20px;"><strong>Número de Placa: </strong> {{ $info->placa }}</p>

    @if($info->descripcion != null)
        <p style="font-size: 20px;"><strong>Descripción: </strong> {{ $info->descripcion }}</p>
    @else
        <p style="font-size: 20px;"><strong>Descripción: </strong> Sin observaciones</p>
    @endif

    <p style="font-size: 20px;"><strong>Estado: </strong> {{ $estado }}</p>

</div>

<div class="firma">
    <p>
        _________________________________<br>
        &nbsp;&nbsp;&nbsp;Lic Esmeralda Rodriguez de Contreras<br>
        &nbsp;&nbsp;&nbsp;&nbsp;Encargada de Inventario y Activo fijo
    </p>
</div>


</body>
</html>
