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
                        <li class="breadcrumb-item active">Reporte por Inventario</li>
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
                                <label>Seleccione una opción:</label>
                                <div class="col-sm-5">
                                    <select class="form-control" id="select-tipo" onchange="verificar(this)">
                                        <option value="0" disabled selected>Seleccione una opción...</option>
                                        <option value="1">Muebles</option>
                                        <option value="2">Inmuebles</option>
                                        <option value="3">Vehículos y Maquinaria</option>
                                        <option value="4">Por Bien</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content" id="bloqueMuebles" style="display: none">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-body">

                        <div class="form-group">

                            <div class="col-md-6">

                                <div class="card card-success">
                                    <form class="form-horizontal">
                                        <div class="card-body">

                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Filtros</label>
                                            </div>

                                                <!-- radio -->
                                                <div class="form-group">


                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio" id="customRadioMueble1" name="customRadioMueble">
                                                        <label for="customRadioMueble1" class="custom-control-label">Mayores a 600</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio" id="customRadioMueble2" name="customRadioMueble">
                                                        <label for="customRadioMueble2" class="custom-control-label">Menores a 600</label>
                                                    </div>
                                                    <div class="custom-control custom-radio">
                                                        <input class="custom-control-input" type="radio" id="customRadioMueble3" name="customRadioMueble">
                                                        <label for="customRadioMueble3" class="custom-control-label">Ver Todos</label>
                                                    </div>

                                                </div>

                                        </div>

                                        <div class="card-footer">
                                            <button type="button" onclick="generarPdfMueble()" class="btn btn-success">Imprimir Reporte</button>
                                        </div>

                                    </form>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section class="content" id="bloqueInmuebles" style="display: none">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-body">

                        <div class="form-group">

                            <div class="col-md-6">

                                <div class="card-footer">
                                    <button type="button" onclick="generarPdfInmueble()" class="btn btn-success">Imprimir Reporte Inventario</button>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section class="content" id="bloqueMaquinaria" style="display: none">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-body">

                        <div class="form-group">

                            <div class="col-md-6">

                                <div class="card-footer">
                                    <button type="button" onclick="generarPdfMaquinaria()" class="btn btn-success">Imprimir Reporte Inventario</button>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section class="content" id="bloqueBien" style="display: none">
            <div class="container-fluid">
                <div class="card card-success">
                    <div class="card-body">

                        <div class="form-group">

                            <div class="col-md-6">

                                <div class="card card-success">
                                    <form class="form-horizontal">
                                        <div class="card-body">

                                            <div class="form-group row">
                                                <label class="col-sm-5 col-form-label">Código de Bien</label>
                                            </div>

                                            <!-- radio -->
                                            <div class="form-group">


                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" id="customRadioMaqui1" name="customRadioMaqui">
                                                    <label for="customRadioMaqui1" class="custom-control-label">Bienes Muebles</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" id="customRadioMaqui2" name="customRadioMaqui">
                                                    <label for="customRadioMaqui2" class="custom-control-label">Bienes Inmuebles</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input class="custom-control-input" type="radio" id="customRadioMaqui3" name="customRadioMaqui">
                                                    <label for="customRadioMaqui3" class="custom-control-label">Maquinaria y equipo</label>
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label>Código</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text"><i class="fas fa-edit"></i></span>
                                                    </div>
                                                    <input type="text" class="form-control" maxlength="100" id="codigo-bienes">
                                                </div>
                                            </div>

                                        </div>

                                        <div class="card-footer">
                                            <button type="button" onclick="generarPdfCodigoBien()" class="btn btn-success">Imprimir Reporte Inventario</button>
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

            if(valor == '1'){ // mueble
               // ocultar todos los bloques
                ocultarTodos();

                // mostrar bloque
                document.getElementById("bloqueMuebles").style.display = "block";
            }
            else if(valor == '2'){ // inmueble
                // ocultar todos los bloques
                ocultarTodos();

                // mostrar bloque
                document.getElementById("bloqueInmuebles").style.display = "block";
            }
            else if(valor == '3'){ // maquinaria
                // ocultar todos los bloques
                ocultarTodos();

                // mostrar bloque
                document.getElementById("bloqueMaquinaria").style.display = "block";
            }
            else if(valor == '4'){ // bien
                // ocultar todos los bloques
                ocultarTodos();

                // mostrar bloque
                document.getElementById("bloqueBien").style.display = "block";
            }
        }

        function ocultarTodos(){
            document.getElementById("bloqueInmuebles").style.display = "none";
            document.getElementById("bloqueMuebles").style.display = "none";
            document.getElementById("bloqueBien").style.display = "none";
            document.getElementById("bloqueMaquinaria").style.display = "none";
        }

        function generarPdfMueble(){
            var radio1 = document.getElementById('customRadioMueble1').checked; // mayor a 600
            var radio2 = document.getElementById('customRadioMueble2').checked; // menor a 600
            var radio3 = document.getElementById('customRadioMueble3').checked; // ver todos

            if(radio1){
                window.open("{{ URL::to('admin/generador/pdf/inventario/muebles') }}/" + 1);
            }
            else if(radio2){
                window.open("{{ URL::to('admin/generador/pdf/inventario/muebles') }}/" + 2);
            }
            else if(radio3){
                window.open("{{ URL::to('admin/generador/pdf/inventario/muebles') }}/" + 3);
            }else{
                toastr.error('Seleccionar una opción');
            }
        }

        function generarPdfInmueble(){
            window.open("{{ URL::to('admin/generador/pdf/inventario/inmueble') }}");
        }

        function generarPdfMaquinaria(){
            window.open("{{ URL::to('admin/generador/pdf/inventario/maquinaria') }}");
        }

        function generarPdfCodigoBien(){
            var radio1 = document.getElementById('customRadioMaqui1').checked; // bienes muebles
            var radio2 = document.getElementById('customRadioMaqui2').checked; // bienes inmuebles
            var radio3 = document.getElementById('customRadioMaqui3').checked; // maquinaria

            var codigo = document.getElementById('codigo-bienes').value;

            if(codigo === ''){
                toastr.error('Código del bien es requerido');
                return;
            }

            var tipo = 0;

            if(radio1){
                tipo = 1;
            }else if(radio2){
                tipo = 2;
            }
            else if(radio3){
                tipo = 3;
            }else{
                toastr.error('Seleccionar una opción');
            }
            var formData = new FormData();
            formData.append('codigo', codigo);
            formData.append('tipo', tipo);
            // buscar si existe el bien
            axios.post(url+'/verificar/bienindividual/existe-codigo', formData, {
            })

                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        // encontrado

                        var id = response.data.id;
                        window.open("{{ URL::to('admin/pdf/bien/individual') }}/" + tipo + "/" + id);
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

    </script>


@endsection
