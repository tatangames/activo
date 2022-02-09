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
                    <h1>Depreciación Anual</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Activo Fijo e Inventario</a></li>
                        <li class="breadcrumb-item active"><a href="#">Formulario de Depreciación</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="content-wrapper">

        <section class="content" id="bloquePrincipal">
            <div class="container-fluid">
                <div class="card card-default">
                    <div class="card-body">

                        <div class="form-group">

                            <div class="form-group row">
                                <label>Seleccione una opción:</label>
                                <div class="col-sm-5">
                                    <select class="form-control" id="select-estado" onchange="verificar(this)">
                                        <option value="0">Seleccione una opción...</option>
                                        <option value="1">Anual General</option>
                                        <option value="2">Anual por Bien</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content" id="bloque1" style="display: none">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-body">

                        <div class="form-group">

                            <div class="col-md-6">

                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Anual General</h3>
                                    </div>

                                    <form class="form-horizontal">
                                        <div class="card-body">

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Año</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="anio-bloque1">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="card-footer">
                                            <button type="button" onclick="generarBloque1()" class="btn btn-success">Buscar</button>
                                            <button type="button" onclick="cancelar()" class="btn btn-default float-right">Cancelar</button>
                                        </div>

                                    </form>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section class="content" id="bloque2" style="display: none">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-body">

                        <div class="form-group">

                            <div class="col-md-6">

                                <div class="card card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Anual por Bien</h3>
                                    </div>

                                    <form class="form-horizontal">
                                        <div class="card-body">

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Código del bien:</label>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="codigo-bloque2" value="UIN-49-96-1">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="card-footer">
                                            <button type="button" onclick="generarBloque2()" class="btn btn-success">Buscar</button>
                                            <button type="button" onclick="cancelar()" class="btn btn-default float-right">Cancelar</button>
                                        </div>

                                    </form>
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

            if(valor == '1'){
                // anual general
                ocultarPrincipal();
                document.getElementById("bloque1").style.display = "block";
            }
            else if(valor == '2'){
                // codigo del bien
                ocultarPrincipal();
                document.getElementById("bloque2").style.display = "block";
            }
        }

        function cancelar(){
            document.getElementById("bloque1").style.display = "none";
            document.getElementById("bloque2").style.display = "none";
            document.getElementById("bloquePrincipal").style.display = "block";
        }

        // generar pdf anual
        function generarBloque1(){

            var anio = document.getElementById("anio-bloque1").value;
            if(anio === ''){
                toastr.error('Año es requerido');
                return;
            }

            window.open("{{ URL::to('admin/reporte/pdf/calculo-anual') }}/" + anio);
        }

        // generar pdf codigo del bien
        function generarBloque2(){
            var codigo = document.getElementById("codigo-bloque2").value;
            if(codigo === ''){
                toastr.error('Código es requerido');
                return;
            }

            openLoading();
            var formData = new FormData();
            formData.append('codigo', codigo);

            axios.post(url+'/verificar/existe-codigo', formData, {
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                       // encontrado
                        window.location.href="{{ url('/admin/reporte/codigo-bien/') }}/" + codigo;
                    }
                    else {
                        // no encontrado
                        msjNoEncontrado();
                    }
                })
                .catch((error) => {
                    toastr.error('Error al registrar');
                    closeLoading();
                });
        }

        function msjNoEncontrado(){
            Swal.fire({
                title: 'Código No encontrado',
                text: '',
                icon: 'info',
                showCancelButton: false,
                confirmButtonColor: '#28a745',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                }
            });
        }

        function ocultarPrincipal(){
            document.getElementById('select-estado').options.selectedIndex = 0;
            document.getElementById("bloquePrincipal").style.display = "none";
        }

    </script>


@endsection
