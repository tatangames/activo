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

        </div>
    </section>

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Reporte</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Activo Fijo e Inventario</li>
                        <li class="breadcrumb-item active">Reporte por Donaciones</li>
                    </ol>
                </div>
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
                                <label>Fecha Inicial</label>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control" id="fechainicio">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label>Fecha Final </label>
                                <div class="col-sm-3">
                                    <input type="date" class="form-control" id="fechafinal">
                                </div>
                            </div>

                            <br>

                            <div class="form-group row">
                                <label>Filtro Bienes:</label>
                                <div class="col-sm-5">
                                    <select class="form-control" id="select-tipo">
                                        <option value="0" disabled selected>Seleccione una opción...</option>
                                        <option value="1">Muebles</option>
                                        <option value="2">Inmuebles</option>
                                        <option value="3">Vehículos y Maquinaria</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="button" onclick="generarPdf()" class="btn btn-success">Imprimir Reporte</button>
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

        function generarPdf(){
            var fechainicio = document.getElementById("fechainicio").value;
            var fechafinal = document.getElementById("fechafinal").value;
            var valor = document.getElementById("select-tipo").value;

            if(fechainicio === ''){
                toastr.error('Fecha inicio es requerido');
                return;
            }

            if(fechafinal === ''){
                toastr.error('Fecha final es requerido');
                return;
            }

            if(valor == '0'){
                toastr.error('Seleccionar un Bien');
                return;
            }

            if(Date.parse(fechainicio) > Date.parse(fechafinal)){
                toastr.error('Fecha Inicial no debe ser mayor');
                return;
            }

            window.open("{{ URL::to('admin/reporte/pdf/donaciones') }}/" + fechainicio + "/" + fechafinal + "/" + valor);
        }

    </script>


@endsection
