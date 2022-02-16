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
<p style="text-align: center; font-weight: bold; font-size: 19px"> Bien Inmueble </p>

<div style="margin: 25px">

    <p style="font-size: 20px;"><strong>Número de inventario: </strong> {{ $info->codigo }}</p>

    <p style="font-size: 20px;"><strong>Descripción: </strong> {{ $info->descripcion }}</p>

    <p style="font-size: 20px;"><strong>Fecha de adquisición: </strong> {{ $fecha }}</p>

    <p style="font-size: 20px;"><strong>Contiene: </strong> {{ $info->contiene }}</p>

    <p style="font-size: 20px;"><strong>Ubicación: </strong> {{ $info->ubicacion }}</p>

    <p style="font-size: 20px;"><strong>Valor de escritura: </strong> $ {{ $info->valor }}</p>

    <p style="font-size: 20px;"><strong>En comodato: </strong> {{ $comodato }}</p>

    <p style="font-size: 20px;"><strong>Valor con revalúo: </strong> $ {{ $reevaluo }}</p>

    @if($infoVariosReevaluo['ReevaluoMenos'] != null)
        <p style="font-size: 20px;"><strong>Reevaluo de menos: </strong> {{ $infoVariosReevaluo['ReevaluoMenos'] }}</p>
    @endif

    @if($infoVariosReevaluo['Superarios'] != null)
        <p style="font-size: 20px;"><strong>Superarios por reevaluos: </strong> {{ $infoVariosReevaluo['Superarios'] }}</p>
    @endif

    <p style="font-size: 20px;"><strong>Valor registrado: </strong>$ {{ $infoVariosReevaluo['Vregistrado'] }}</p>

    <p style="font-size: 20px;"><strong>Edificaciones: </strong> $ {{ $info->edificaciones }}</p>

    <p style="font-size: 20px;"><strong>Valor registrado + Edificaciones e Instalaciones: </strong> $ {{ $infoVariosReevaluo['sumatoria'] }}</p>

    <p style="font-size: 20px;"><strong>Observaciones: </strong> {{ $info->observaciones }}</p>

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
