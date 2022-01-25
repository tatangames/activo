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
        <p style="text-align: center; font-size: 19px; font-weight: bold;">UNIDAD DE INVENTARIO Y ACTIVO FIJO <br>
            REPORTE DE INVENTARIO <br> ________________________________</p>
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
<h2 style="text-align: center; font-size: 16px"> Bienes Muebles Municipales </h2>
@if($haydatos == false)
    <p style="margin-left: 60px; font-size: 18px">No hay Registros </p>
@else

    <div id="content">
        <table id="tabla" style="width: 95%; margin-top: 30px; margin-bottom: 35px" >
            <thead>
            <tr>
                <th style="text-align: center; color: black; font-size:15px; width: 12%">Nº de Mueble</th>
                <th style="text-align: center; color: black; font-size:15px; width: 20%">Descripción</th>
                <th style="text-align: center; color: black; font-size:15px; width: 11%">Fecha de Compra</th>
                <th style="text-align: center; color: black; font-size:15px; width: 11%">Valor compra</th>
            </tr>
            </thead>

            @foreach($lista as $item)
                <tr>
                    <td style="font-size:13px; text-align: center">{{ $item->codigo }}</td>
                    <td style="font-size:13px; text-align: left">{{ $item->descripcion }}</td>
                    <td style="font-size:13px; text-align: center">{{ $item->fechacompra }}</td>
                    <td style="font-size:13px; text-align: center">{{ $item->valor }}</td>
                </tr>

            @endforeach

            <tr>
                <td style="font-size:13px; text-align: center; font-weight: bold" colspan="3">Total</td>
                <td style="font-size:13px; text-align: center; font-weight: bold">${{ $total }}</td>
            </tr>

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

@endif

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
