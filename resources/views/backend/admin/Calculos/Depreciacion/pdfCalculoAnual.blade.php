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
            ACTIVO FIJO <br> DEPRECIACION ANUAL {{ $anio }}</p>
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

    <br>


<div id="content">
    <table id="tabla" style="width: 95%; margin-top: 30px; margin-bottom: 35px" >
        <thead>
        <tr>
            <th style="text-align: center; color: black; font-size:13px; width: 12%">CÓDIGO</th>
            <th style="text-align: center; color: black; font-size:13px; width: 12%">DESCRIPCIÓN</th>
            <th style="text-align: center; color: black; font-size:13px; width: 12%">RUBRO</th>
            <th style="text-align: center; color: black; font-size:13px; width: 12%">DEP. ANUAL</th>
            <th style="text-align: center; color: black; font-size:13px; width: 12%">24199017</th>
            <th style="text-align: center; color: black; font-size:13px; width: 12%">24199019</th>
        </tr>
        </thead>

        <tbody>

        @foreach($dataArray as $data)

            <tr>
                <td style="font-size: 13px">{{ $data['codigo'] }}</td>
                <td style="font-size: 13px">{{ $data['descripcion'] }}</td>
                <td style="font-size: 13px">{{ $data['coddepre'] }}</td>
                <td style="font-size: 13px">{{ $data['depanual'] }}</td>
                <td style="font-size: 13px">{{ $data['col1'] }}</td>
                <td style="font-size: 13px">{{ $data['col2'] }}</td>
            </tr>


        @endforeach
        <tr>
        <td style="font-size: 13px; border-style: none;"></td>
        <td style="font-size: 13px; border-style: none;"></td>
        <td style="font-size: 13px; border-style: none;"></td>
        <td style="font-size: 13px">{{ $totaldep }}</td>
        <td style="font-size: 13px">{{ $total17 }}</td>
        <td style="font-size: 13px">{{ $total19 }}</td>
        </tr>

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
        $x = 355;
        $y = 575;
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
