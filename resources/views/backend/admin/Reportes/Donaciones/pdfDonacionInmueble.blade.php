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
        <p style="text-align: center; font-size: 25px; font-weight: bold;">UNIDAD DE INVENTARIO Y ACTIVO FIJO <br>
            REPORTE DE INVENTARIO <br> ________________________________</p>
    </div>
</div>

<h2 style="text-align: center; font-size: 19px">Donaciones realizadas desde: {{ $f1 }} hasta {{ $f2 }} <br> <br> Bienes Inmuebles </h2>
@if($haydatos == false)
    <p style="margin-left: 60px; font-size: 18px">No hay Registros en el periodo especificado </p>
@else

    <div id="content">
        <table id="tabla" style="table-layout:fixed;">
            <thead>
            <tr>
                <th style="text-align: center; color: black; font-size:15px; width: 12%">Código</th>
                <th style="text-align: center; color: black; font-size:15px; width: 20%">Descripción</th>
                <th style="text-align: center; color: black; font-size:15px; width: 11%">Institución</th>
                <th style="text-align: center; color: black; font-size:15px; width: 11%">Fecha</th>
            </tr>
            </thead>

            @foreach($lista as $item)
                <tr>
                    <td style="text-align: center">{{ $item->codigo }}</td>
                    <td style="text-align: left">{{ $item->descripcion }}</td>
                    <td style="text-align: left">{{ $item->institucion }}</td>
                    <td style="text-align: center">{{ $item->fecha }}</td>
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
