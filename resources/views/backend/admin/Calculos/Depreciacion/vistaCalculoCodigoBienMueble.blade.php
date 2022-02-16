@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/estiloToggle.css') }}" type="text/css" rel="stylesheet" />

@stop

<style>
    table{
        /*Ajustar tablas*/
        table-layout:fixed;
    }
</style>

<div id="divcontenedor" style="display: none">

    <section class="content-header">
        <div class="container-fluid">
            <label>ANALISIS DE DEPRECIACIÓN DE BIENES MUEBLES</label> <br>
            <button type="button" onclick="opcionGuardar()" class="btn btn-success btn-sm">
                <i class="fas fa-pencil-alt"></i>
                Guardar Registro
            </button>

            <button type="button" onclick="verPDF()" class="btn btn-success btn-sm">
                <i class="fas fa-pencil-alt"></i>
                Generar PDF
            </button>

            <div style="float: right">
                <button type="button" onclick="opcionBorrar()" style="float: right" class="btn btn-danger btn-sm">
                    <i class="fas fa-trash-alt"></i>
                    Borrar Registro
                </button>
            </div>
        </div>
    </section>

    <div class="content-wrapper">

        <section class="content">
            <div class="container-fluid">
                <div class="card card-default">
                    <div class="card-body">

                        <div class="form-group">

                                <div class="form-group row">
                                    <label class="col-sm-2">Código del bien:</label>
                                    <div class="col-sm-8">
                                        <p>{{ $info->codigo }}</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2">Descripción:</label>
                                    <div class="col-sm-8">
                                        <p>{{ $info->descripcion }}</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2">Cód. Contable:</label>
                                    <div class="col-sm-8">
                                        <p>{{ $datos['contable'] }}</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2">Cód. de Depreciación:</label>
                                    <div class="col-sm-8">
                                        <p>{{ $datos['depreciacion'] }}</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2">Unidad Asignada:</label>
                                    <div class="col-sm-8">
                                        <p>{{ $datos['unidad'] }}</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2">Valor del bien:</label>
                                    <div class="col-sm-8">
                                        <p>${{ $info->valor }}</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2">Fecha de compra:</label>
                                    <div class="col-sm-8">
                                        <p>{{ $datos['anio'] }}</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2">Valor residual:</label>
                                    <div class="col-sm-8">
                                        <p>${{ $datos['valorresidual'] }}</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2">% Valor Residual:</label>
                                    <div class="col-sm-8">
                                        <p>{{ $info->valresidual }}%</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2">Valor a depreciar:</label>
                                    <div class="col-sm-8">
                                        <p>${{ $datos['valoradepreciar'] }}</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2">Vida Util(años):</label>
                                    <div class="col-sm-8">
                                        <p>{{ $info->vidautil }}</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2">Años pendientes:</label>
                                    <div class="col-sm-8">
                                        <p>{{ $datos['aniopendiente'] }}</p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2">Depreciación anual(prom):</label>
                                    <div class="col-sm-8">
                                        <p>${{ $datos['depanual'] }}</p>
                                    </div>
                                </div>


                            @foreach($repvit as $rep)

                                <section class="content" style="border-style: groove; border-width: 3px">
                                    <div class="container-fluid">
                                        <div class="row">

                                            <div class="col-md-6">

                                                <div class="form-group row">
                                                    <label class="col-sm-4">Fecha Modificación:</label>
                                                    <div class="col-sm-8">
                                                        <p>{{ $rep->dfechamodificacion }}</p>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4">Pieza Sustituida:</label>
                                                    <div class="col-sm-8">
                                                        <p>{{ $rep->dpiezasustituida }}</p>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4">Pieza Nueva:</label>
                                                    <div class="col-sm-8">
                                                        <p>{{ $rep->dpiezanueva }}</p>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4">Nuevo Valor del Bien:</label>
                                                    <div class="col-sm-8">
                                                        <p>{{ $rep->dnuevovalorbien }}</p>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4">Valor Ajustado:</label>
                                                    <div class="col-sm-8">
                                                        <p>{{ $rep->dvalorajustado }}</p>
                                                    </div>
                                                </div>

                                            </div>


                                            <div class="col-md-6">

                                                <div class="form-group row">
                                                    <label class="col-sm-4">Nuevo Valor:</label>
                                                    <div class="col-sm-8">
                                                        <p>{{ $rep->dnuevovalor }}</p>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4">Valor Residual:</label>
                                                    <div class="col-sm-8">
                                                        <p>{{ $rep->dvalorresidual }}</p>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4">Valor a Depreciar:</label>
                                                    <div class="col-sm-8">
                                                        <p>{{ $rep->dvalordepreciar }}</p>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4">Vida Util:</label>
                                                    <div class="col-sm-8">
                                                        <p>{{ $rep->vidautil }}</p>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-sm-4">Depreciación Anual:</label>
                                                    <div class="col-sm-8">
                                                        <p>{{ $rep->ddepreciacionanual }}</p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <br>

                            @endforeach

                            <br>

                            <table id="tabla" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>AÑO</th>
                                    <th>DEPRECIACIÓN ANUAL</th>
                                    <th>DEPRECIACIÓN ACUMULADA</th>
                                    <th>VALOR EN LIBROS</th>

                                </tr>
                                </thead>

                                <tbody>

                                @foreach($dataArray as $data)

                                    @if($data['color'] == 1)

                                        <tr style="background-color: #ddd;">
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
                    </div>

                </div>
            </div>
        </section>

    </div>

</div>

@extends('backend.menus.footerjs')
@section('archivos-js')

    <script src="{{ asset('js/jquery.dataTables.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.js') }}" type="text/javascript"></script>

    <script src="{{ asset('js/toastr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/axios.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/alertaPersonalizada.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){


            document.getElementById("divcontenedor").style.display = "block";
        });
    </script>

    <script>

    function opcionGuardar(){
        Swal.fire({
            title: 'Guardar Registro?',
            text: "",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si'
        }).then((result) => {
            if (result.isConfirmed) {
                guardar();
            }
        })
    }

    function opcionBorrar(){
        Swal.fire({
            title: 'Borrar Registro?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Borrar'
        }).then((result) => {
            if (result.isConfirmed) {
                borrar();
            }
        })
    }

    function guardar(){

        var idbien = {{ $idbien }};

        var formData = new FormData();
        formData.append('id', idbien);

        axios.post(url+'/guardar/historiada/mueble', formData, {
        })
            .then((response) => {

                closeLoading();

                if(response.data.success === 1){
                    toastr.success('Guardado correctamente');
                }
                else {
                    toastr.error('Error al registrar');
                }
            })
            .catch((error) => {
                toastr.error('Error al registrar');
                closeLoading();
            });
    }

    function verPDF(){

        var idbien = {{ $idbien }};

        window.open("{{ URL::to('admin/calculo/mueble/pdf') }}/" + idbien);
    }

    function borrar(){

        var idbien = {{ $idbien }};

        var formData = new FormData();
        formData.append('id', idbien);

        axios.post(url+'/borrar/historiada/mueble', formData, {
        })
            .then((response) => {

                closeLoading();

                if(response.data.success === 1){
                    toastr.success('Registro eliminado');
                }
                else {
                    toastr.error('Error al eliminar');
                }
            })
            .catch((error) => {
                toastr.error('Error al eliminar');
                closeLoading();
            });
    }

    </script>


@endsection
