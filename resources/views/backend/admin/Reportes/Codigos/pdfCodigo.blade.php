<html>
<head>
    <meta charset="UTF-8" />
    <title>Alcaldía Metapán | Reporte</title>

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
        <img src="{{ asset('images/elsalvador.png') }}" style="float: left" alt="" height="88px" width="86px">
        <p style="text-align: center; font-size: 19px; font-weight: bold;">ALCALDIA MUNICIPAL DE METAPAN <br>
            REPORTE DE CUENTAS CONTABLES <br> ________________________________</p>
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
<h2 style="text-align: center; font-size: 16px">Fecha desde: {{ $f1 }} hasta {{ $f2 }} </h2>

    <div id="content">
        @foreach($listado as $item)

        <table id="tabla" style="width: 95%; margin-top: 30px; margin-bottom: 35px" >
                <thead>
                <tr>
                    <th style="text-align: center; color: black; font-size:13px; width: 12%">Código</th>
                    <th style="text-align: center; color: black; font-size:13px; width: 11%">Fecha</th>
                    <th style="text-align: center; color: black; font-size:13px; width: 20%">Nombre</th>
                    <th style="text-align: center; color: black; font-size:13px; width: 11%">Valor</th>
                </tr>

                <tr>
                    <th style="text-align: center; color: black; font-size:12px; width: 12%">{{ $item->codconta }}</th>
                    <td style="text-align: center; color: black; font-weight: bold; font-size:12px; width: 20%" colspan="3">{{ $item->nombre }}</td>
                </tr>
                </thead>

            @foreach($item->extra as $datos)

                <tr>
                    <td style="font-size:12px; text-align: center">{{ $datos->codigo }}</td>
                    <td style="font-size:12px; text-align: center">{{ $datos->fechacompra }}</td>
                    <td style="font-size:12px; text-align: left">{{ $datos->descripcion }}</td>
                    <td style="font-size:12px; text-align: center">${{ $datos->valor }}</td>
                </tr>

            @endforeach

            <tr>
                <td style="font-size:12px; text-align: center; font-weight: bold" colspan="3">TOTAL DE {{ $item->nombre }}:</td>
                <td style="font-size:12px; text-align: center">${{ $item->total }}</td>
            </tr>

        </table>

        @endforeach
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
