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
                    <h1>Nuevo Registro</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Activo Fijo e Inventario</li>
                        <li class="breadcrumb-item active">Ingresar Nuevo Bien</li>
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
                                <label>Tipo de Bien a Registrar:</label>
                                <div class="col-sm-5">
                                    <select class="form-control" id="select-tipo" onchange="verificar(this)">
                                        <option value="0" disabled selected>Seleccione una opción...</option>
                                        <option value="1">Muebles</option>
                                        <option value="2">Inmuebles</option>
                                        <option value="3">Vehículos y Maquinaria</option>
                                    </select>
                                </div>
                            </div>
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

        function verificar(val){
            var valor = val.value;

            if(valor == '1'){ // mueble
                window.location.href="{{ url('/admin/principal/bien/muebles') }}";
            }
            else if(valor == '2'){ // inmueble
                window.location.href="{{ url('/admin/principal/bien/inmuebles') }}";
            }
            else if(valor == '3'){ // maquinaria
                window.location.href="{{ url('/admin/principal/bien/vehiculo') }}";
            }
            else{ // bien
                window.location.href="{{ url('/admin/principal/bien/muebles') }}";
            }
        }


    </script>


@endsection
