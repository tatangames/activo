<html>
<head>
    <meta charset="UTF-8" />
    <title>Alcaldía Metapán | Reporte</title>

    <style>
        .firma {
            left: 0;
            font-size: 20px;
            margin-top: 200px;
            text-align: left;
            page-break-inside: avoid;
        }

        br[style] {
            display:none;
        }

        #tabla {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin-top: 30px;
            text-align: center;
            border: 0.5px solid #000000;
        }

        #tabla td{
            border: 0.5px solid #000000;
            padding: 8px;
            text-align: center;
            font-size: 16px;
            font-family: Arial;
            letter-spacing: -7px;
        }

        #tabla th {
            border: 0.5px solid #000000;
            padding: 3px;
            text-align: center;
        }

        #tabla th {
            padding-top: 6px;
            padding-bottom: 6px;
            background-color: #e3e3e3;
            color: #1E1E1E;
            text-align: center;
            font-size: 15px;
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
        <p style="text-align: center; font-size: 25px; font-weight: bold;">ALCALDIA MUNICIPAL DE METAPAN <br>
            REPORTE DE CUENTAS CONTABLES <br> ________________________________</p>
    </div>

</div>


<h2 style="text-align: center; font-size: 16px">Fecha desde: {{ $f1 }} hasta {{ $f2 }} </h2>

    <div id="content">
        @foreach($listado as $item)

        <table id="tabla" style="table-layout:fixed;">
                <thead>
                <tr>
                    <th style="text-align: center; color: black; font-size:13px; width: 12%">Código</th>
                    <th style="text-align: center; color: black; font-size:13px; width: 11%">Fecha</th>
                    <th style="text-align: center; color: black; font-size:13px; width: 20%">Nombre</th>
                    <th style="text-align: center; color: black; font-size:13px; width: 11%">Valor</th>
                </tr>

                <tr>
                    <th style="text-align: center; color: black; width: 12%">{{ $item->codconta }}</th>
                    <td style="text-align: center; color: black; font-size: 15px; font-weight: bold; width: 20%" colspan="3">{{ $item->nombre }}</td>
                </tr>
                </thead>

            @foreach($item->extra as $datos)

                <tr>
                    <td style="text-align: center">{{ $datos->codigo }}</td>
                    <td style="text-align: center">{{ $datos->fechacompra }}</td>
                    <td style="text-align: left">{{ $datos->descripcion }}</td>
                    <td style="text-align: center">${{ $datos->valor }}</td>
                </tr>

            @endforeach

            <tr>
                <td style="font-size:12px; text-align: center; font-weight: bold" colspan="3">TOTAL DE {{ $item->nombre }}:</td>
                <td style="font-size:12px; text-align: center">${{ $item->total }}</td>
            </tr>

        </table>

        @endforeach

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
