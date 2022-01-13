@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/jquery-ui.min.css') }}" type="text/css" rel="stylesheet" />
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
                    <h1>Registro de Descargo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <p class="breadcrumb-item">Descargo</p>
                        <p class="breadcrumb-item active">Registro</p>
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
                                <label class="col-sm-2 col-form-label">Tipo de Bien:</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <select class="form-control" id="select-tipo">
                                            <option value="0" disabled selected>Seleccione una opción...</option>
                                            <option value="1">Muebles</option>
                                            <option value="2">Vehículos y Maquinaria</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Nombre y/o Descripción del Bien:</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <input type="text" name="descripcion" id="descripcion" class="form-control input-lg" autocomplete="off"/>
                                        <div id="countryList" style="position: absolute; z-index: 9;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Valor:</label>

                                <div class="col-sm-3">
                                    <input type="number" value="0.00" class="form-control" id="valor">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Fecha:</label>

                                <div class="col-sm-3">
                                    <input type="date" class="form-control" id="fecha">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Observaciones:</label>
                                <div class="col-sm-8">
                                    <input id="observaciones" class="form-control" type="text" value="" maxlength="450">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" onclick="salir()">Cancelar</button>
                        <button type="button" class="btn btn-primary" onclick="verificar()">Guardar</button>
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
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            document.getElementById("divcontenedor").style.display = "block";

            window.idGlobalBienDescargo = 0;

            $('#descripcion').keyup(function(){

                var tipo = document.getElementById("select-tipo").value;
                var query = $(this).val();

                if(tipo == '0'){
                    toastr.error('seleccionar Tipo de Bien');
                    return;
                }

                else if(tipo == '1'){

                    if(query != ''){
                        axios.post(url+'/descargo/buscar/bien/mueble', {
                            'query' : query
                        })
                            .then((response) => {

                                $('#countryList').fadeIn();
                                $('#countryList').html(response.data);

                                if(response.data == ''){
                                    idGlobalBienDescargo = 0;
                                }
                            })
                            .catch((error) => {
                            });
                    }else{
                        idGlobalBienDescargo = 0;
                    }
                }

                else if(tipo == '2'){

                    if(query != ''){
                        axios.post(url+'/descargo/buscar/bien/maquinaria', {
                            'query' : query
                        })
                            .then((response) => {

                                $('#countryList').fadeIn();
                                $('#countryList').html(response.data);

                                if(response.data == ''){
                                    idGlobalBienDescargo = 0;
                                }
                            })
                            .catch((error) => {
                            });
                    }else{
                        idGlobalBienDescargo = 0;
                    }
                }else{
                    idGlobalBienDescargo = 0;
                }

            });

            $(document).on('click', 'li', function(){
                $('#descripcion').val($(this).text());
                $('#countryList').fadeOut();
            });

            $(document).click(function(){
                $('#countryList').fadeOut();
            });

        });

        // esta funcion se ejecuta cuando seleccionamos un item
        function modificarValor(id, valor) {
            idGlobalBienDescargo = id;
            if(valor != null) {
                $('#valor').val(valor.toFixed(2));
            }
        }

        function salir(){
            window.location.href="{{ url('/admin/principal/index') }}";
        }

        function verificar(){
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

        function guardar(){
            var tipo = document.getElementById("select-tipo").value;

            var valor = document.getElementById("valor").value;
            var fecha = document.getElementById("fecha").value;
            var observaciones = document.getElementById("observaciones").value;

            if(tipo == '0'){
                toastr.error('seleccionar Tipo de Bien');
                return;
            }

            var reglaNumeroDecimal = /^[0-9]\d*(\.\d+)?$/;

            if(valor.length > 0){

                if(!valor.match(reglaNumeroDecimal)) {
                    toastr.error('Valor debe ser número Decimal');
                    return;
                }

                if(valor < 0){
                    toastr.error('Valor no permite números negativos');
                    return;
                }

                if(valor.length > 9){
                    toastr.error('Valor máximo 9 digitos de límite');
                    return;
                }
            }

            if(observaciones.length > 0){
                if(observaciones.length > 450){
                    toastr.error('máximo 450 caracteres para observaciones');
                    return;
                }
            }

            openLoading();
            var formData = new FormData();
            formData.append('id', idGlobalBienDescargo);
            formData.append('tipo', tipo);
            formData.append('valor', valor);
            formData.append('observaciones', observaciones);
            formData.append('fecha', fecha);

            axios.post(url+'/descargo/nuevo', formData, {
            })
                .then((response) => {
                    closeLoading();

                    if(response.data.success === 1){
                        modalNoEncontrado();
                    }
                    else if(response.data.success === 2){
                        actualizar();
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

        function actualizar(){
            Swal.fire({
                title: 'Registrado correctamente',
                text: '',
                icon: 'success',
                showCancelButton: false,
                allowOutsideClick: false,
                confirmButtonColor: '#28a745',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href="{{ url('/admin/descargo/index') }}";
                }
            });
        }

        function modalNoEncontrado(){
            Swal.fire({
                title: 'No encontrado',
                text: 'El Nombre y/o Descripción del Bien No se Encuentra',
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
