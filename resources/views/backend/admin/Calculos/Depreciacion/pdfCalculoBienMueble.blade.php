<html>
<head>
    <meta charset="UTF-8" />
    <title>Alcaldía de Metapán | Reporte</title>

    <style>
        @page {
            margin: 120px 50px 80px 50px;
        }

        #header {
            position: fixed;
            top: -100px;
            width: 100%;
        }

        footer {
            position: fixed;
            bottom: 75px;
            height: 5px;
        }

        footer .page-number {
            text-align: center;
        }

        br[style] {
            display:none;
        }

        #tabla {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
            margin-left: 20px;
            margin-right: 20px;
            margin-top: 90px;
            text-align: center;
        }

        #tabla td{
            border: 1px solid #000000;
            padding: 8px;
            text-align: center;
            font-size: 15px;
        }

        #tabla th {
            border: 1px solid #000000;
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

    </style>
</head>
<body>
<div id="header">
    <div class="content">
        <img src="{{ asset('images/logo2.png') }}" style="float: right" alt="" height="88px" width="71px">
        <p style="text-align: center; font-size: 17px; font-family: Tahoma; font-weight: bold;">ALCALDIA MUNICIPAL DE METAPÁN <br>
            ACTIVO FIJO <br> ANALISIS DE DEPRECIACIÓN DE BIENES MUEBLES</p>
    </div>

</div>

<footer>
    <table>
        <tr>
            <td>

            </td>
            <td>
                <p class="page">

                </p>
            </td>
        </tr>
    </table>
</footer>

    <section style="margin-left: 20px">

        <div class="row" style="font-size: 15px">
            <p>Código del bien: {{ $info->codigo }} </p>

            <p>Descripción: {{ $info->descripcion }}</p>

            <p>Cód. Contable: {{ $datos['contable'] }}</p>

            <p>Cód. de Depreciación: {{ $datos['depreciacion'] }}</p>

        </div>


        <div style="clear:both; position:relative;">
            <div style="position:absolute; left:0pt; width:300pt;">

                <p>Unidad Asignada: {{ $datos['unidad'] }}</p>

                <p>Valor del bien: ${{ $info->valor }}</p>

                <p>Valor residual: ${{ $info->valresidual }}</p>

                <p>Valor a depreciar: ${{ $datos['valoradepreciar'] }}</p>

                <p>Años pendientes: {{ $datos['aniopendiente'] }}</p>

            </div>

            <div style="margin-left:275pt;">

                <p>Fecha de compra: {{ $datos['anio'] }}</p>

                <p>% Valor Residual: {{ $info->valresidual }}%</p>

                <p>Vida Util(años): {{ $info->vidautil }}</p>

                <p>Depreciación anual(prom): ${{ $datos['depanual'] }}</p>

            </div>
        </div>

    </section>

    <br>
    <br>

    @foreach($repvit as $rep)

        <div style="margin-left: 20px; background: #D2D2D2">

            <div style="clear:both; position:relative;">
                <div style="position:absolute; left:0pt; width:300pt;">

                    <p> &nbsp;Fecha Modificación: {{ $rep->dfechamodificacion }}</p>

                    <p> &nbsp;Pieza Sustituida: {{ $rep->dpiezasustituida }}</p>

                    <p> &nbsp;Pieza Nueva: {{ $rep->dpiezanueva }}</p>

                    <p> &nbsp;Nuevo Valor del Bien: {{ $rep->dnuevovalorbien }}</p>

                    <p> &nbsp;Valor Ajustado: {{ $rep->dvalorajustado }}</p>

                </div>
                <div style="margin-left:275pt;">

                    <p>Nuevo Valor: {{ $rep->dnuevovalor }}</p>

                    <p>Valor Residual: {{ $rep->dvalorresidual }}</p>

                    <p>Valor a Depreciar: {{ $rep->dvalordepreciar }}</p>

                    <p>Vida Util: {{ $rep->vidautil }}</p>

                    <p>Depreciación Anual: {{ $rep->ddepreciacionanual }}</p>

                </div>
            </div>

        </div>

        <br>

    @endforeach

    <div id="content">
        <table id="tabla" style="width: 95%; margin-top: 30px; margin-bottom: 35px" >
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
                        <td style="font-size: 13px">{{ $data['aniocompra'] }}</td>
                        <td style="font-size: 13px">$ {{ $data['depanterior'] }}</td>
                        <td style="font-size: 13px">$ {{ $data['depacumulada'] }}</td>
                        <td style="font-size: 13px">$ {{ $data['new2'] }}</td>
                    </tr>

                @else

                    <tr style="background-color: #eee;">
                        <td style="font-size: 13px">{{ $data['aniocompra'] }}</td>
                        <td style="font-size: 13px">$ {{ $data['depanterior'] }}</td>
                        <td style="font-size: 13px">$ {{ $data['depacumulada'] }}</td>
                        <td style="font-size: 13px">$ {{ $data['new2'] }}</td>
                    </tr>

                @endif

            @endforeach

            </tbody>

        </table>
        <br>
        <br>
        <br>
        <p style="margin-left: 20px">
            _________________________________<br>
            Lic Esmeralda Rodriguez de Contreras<br>
            Encargada de Inventario y Activo fijo
        </p>
    </div>


<script type="text/php">
    if (isset($pdf)) {
        $x = 258;
        $y = 760;
        $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
        $font = null;
        $size = 10;
        $color = array(0,0,0);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
    }

</script>

</body>
</html>
