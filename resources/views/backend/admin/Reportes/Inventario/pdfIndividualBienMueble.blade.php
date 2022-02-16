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
<p style="text-align: center; font-weight: bold; font-size: 19px"> Bien Mueble </p>

<div style="margin: 25px">

    <p style="font-size: 20px;"><strong>Número de inventario: </strong> {{ $info->codigo }}</p>

    <p style="font-size: 20px;"><strong>Descripción: </strong> {{ $info->descripcion }}</p>

    <p style="font-size: 20px;"><strong>Valor del bien: </strong> ${{ $info->valor }}</p>

    <p style="font-size: 20px;"><strong>Fecha de compra: </strong> {{ $fecha }}</p>

    <p style="font-size: 20px;"><strong>Departamento: </strong> {{ $departamento }}</p>

    <p style="font-size: 20px;"><strong>Tipo de bien: </strong> {{ $tipobien }}</p>

    @if($info->valor > 600)

        <p style="font-size: 20px;"><strong>Código contable: </strong>{{ $txtCodContable }}</p>

        <p style="font-size: 20px;"><strong>Código depreciación: </strong>{{ $txtCodDepreciacion }}</p>

        <p style="font-size: 20px;"><strong>Vida util: </strong>{{ $info->vidautil }}</p>

        <p style="font-size: 20px;"><strong>Valor residual: </strong>{{ $info->valresidual }}</p>

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
