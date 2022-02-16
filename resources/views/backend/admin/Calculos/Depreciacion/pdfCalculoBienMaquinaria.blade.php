<html>
<head>
    <meta charset="UTF-8" />
    <title>Alcaldía de Metapán | Reporte</title>

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

        #tabla2 {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin-top: 30px;
            text-align: center;
            border: none;
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

        #tabla2 td{
            border: white;
            padding: 8px;
            text-align: center;
            font-size: 17px;
            font-family: Arial;
            letter-spacing: -7px;
        }

        #tabla2 th {
            border: none;
            padding: 3px;
            text-align: center;
        }

        #tabla2 th {
            padding-top: 6px;
            padding-bottom: 6px;
            background-color: #e3e3e3;
            color: #1E1E1E;
            text-align: center;
            font-size: 18px;
        }

        thead {
            display: table-row-group;
        }

        p{
            font-size: 19px;
        }

    </style>
</head>
<body>
<div id="header">
    <div class="content">
        <img src="{{ asset('images/logo2.png') }}" style="float: right" alt="" height="88px" width="71px">
        <p style="text-align: center; font-size: 22px; font-family: Tahoma; font-weight: bold;">ALCALDIA MUNICIPAL DE METAPÁN <br>
            ACTIVO FIJO <br> ANALISIS DE DEPRECIACIÓN DE VEHÍCULO Y MAQUINARIA</p>
    </div>

</div>

<div class="row" style="font-size: 15px">
    <p>Código del bien: {{ $info->codigo }} </p>

    <p>Descripción: {{ $info->descripcion }}</p>

    <p>Cód. Contable: {{ $datos['contable'] }}</p>

    <p>Cód. de Depreciación: {{ $datos['depreciacion'] }}</p>

</div>

<div id="content">
    <table id="tabla2"  style="table-layout:fixed;">
        <thead>
        <tr>

        </tr>
        </thead>

        <tbody>

        <tr>
            <td style="text-align: left; width: 45%;">Unidad Asignada: {{ $datos['unidad'] }}</td>
            <td style="text-align: left; width: 45%;">Fecha de compra: {{ $datos['anio'] }}</td>
        </tr>

        <tr>
            <td style="text-align: left; width: 45%;">Valor del bien: ${{ $info->valor }}</td>
            <td style="text-align: left; width: 45%;">% Valor Residual: {{ $info->valresidual }}%</td>
        </tr>

        <tr>
            <td style="text-align: left; width: 45%;">Valor residual: ${{ $info->valresidual }}</td>
            <td style="text-align: left; width: 45%;">Vida Util (años): {{ $info->vidautil }}</td>
        </tr>

        <tr>
            <td style="text-align: left; width: 45%;">Valor a depreciar: ${{ $datos['valoradepreciar'] }}</td>
            <td style="text-align: left; width: 45%;">Depreciación anual (prom): ${{ $datos['depanual'] }}</td>
        </tr>

        <tr>
            <td style="text-align: left; width: 45%;">Años pendientes: {{ $datos['aniopendiente'] }}</td>
            <td></td>
        </tr>

        </tbody>
    </table>
</div>


@foreach($repvit as $rep)

    <div id="content">
        <table id="tabla2"  style="table-layout:fixed; background-color: #d0d0d0">
            <thead>
            <tr>

            </tr>
            </thead>

            <tbody>

            <tr>
                <td style="text-align: left; width: 45%;">Fecha Modificación: {{ $rep->dfechamodificacion }}</td>
                <td style="text-align: left; width: 45%;">Nuevo Valor: {{ $rep->dnuevovalor }}</td>
            </tr>


            <tr>
                <td style="text-align: left; width: 45%;">Pieza Sustituida: {{ $rep->dpiezasustituida }}</td>
                <td style="text-align: left; width: 45%;">Valor Residual: {{ $rep->dvalorresidual }}</td>
            </tr>

            <tr>
                <td style="text-align: left; width: 45%;">Pieza Nueva: {{ $rep->dpiezanueva }}</td>
                <td style="text-align: left; width: 45%;">Valor a Depreciar: {{ $rep->dvalordepreciar }}</td>
            </tr>

            <tr>
                <td style="text-align: left; width: 45%;">Nuevo Valor del Bien: {{ $rep->dnuevovalorbien }}</td>
                <td style="text-align: left; width: 45%;">Vida Util: {{ $rep->vidautil }}</td>
            </tr>

            <tr>
                <td style="text-align: left; width: 45%;">Valor Ajustado: {{ $rep->dvalorajustado }}</td>
                <td style="text-align: left; width: 45%;">Depreciación Anual: {{ $rep->ddepreciacionanual }}</td>
            </tr>

            </tbody>
        </table>
    </div>

@endforeach

<div id="content">
    <table id="tabla" style="table-layout:fixed;">
        <thead>
        <tr>
            <th style="text-align: center; color: black; font-size:13px; width: 12%">AÑO</th>
            <th style="text-align: center; color: black; font-size:13px; width: 12%">DEPRECIACIÓN ANUAL</th>
            <th style="text-align: center; color: black; font-size:13px; width: 12%">DEPRECIACIÓN ACUMULADA</th>
            <th style="text-align: center; color: black; font-size:13px; width: 12%">VALOR EN LIBROS
        </tr>
        </thead>

        <tbody>

        @foreach($dataArray as $data)

            @if($data['color'] == 1)

                <tr style="background-color: #b0b0b0;">
                    <td>{{ $data['aniocompra'] }}</td>
                    <td>$ {{ $data['depanterior'] }}</td>
                    <td>$ {{ $data['depacumulada'] }}</td>
                    <td>$ {{ $data['new2'] }}</td>
                </tr>

            @else

                <tr style="background-color: #eee;">
                    <td>{{ $data['aniocompra'] }}</td>
                    <td>$ {{ $data['depanterior'] }}</td>
                    <td>$ {{ $data['depacumulada'] }}</td>
                    <td>$ {{ $data['new2'] }}</td>
                </tr>

            @endif

        @endforeach

        </tbody>
    </table>
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
