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
        <p style="text-align: center; font-size: 25px; font-family: Tahoma; font-weight: bold;">ALCALDIA MUNICIPAL DE METAPÁN <br>
            ACTIVO FIJO <br> DEPRECIACION ANUAL {{ $anio }}</p>
    </div>

</div>

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

        @foreach($sortedArray as $data)

            <tr>
                <td>{{ $data['codigo'] }}</td>
                <td>{{ $data['descripcion'] }}</td>
                <td>{{ $data['coddepre'] }}</td>
                <td>{{ $data['depanual'] }}</td>
                <td>{{ $data['col1'] }}</td>
                <td>{{ $data['col2'] }}</td>
            </tr>

        @endforeach
        <tr>
        <td style="border-style: none;"></td>
        <td style="border-style: none;"></td>
        <td style="border-style: none;"></td>
        <td>$ {{ $totaldep }}</td>
        <td>$ {{ $total17 }}</td>
        <td>$ {{ $total19 }}</td>
        </tr>

        </tbody>

    </table>

</div>

</body>
</html>
