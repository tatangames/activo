@extends('backend.menus.superior')

@section('content-admin-css')
    <link href="{{ asset('css/adminlte.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/dataTables.bootstrap4.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/toastr.min.css') }}" type="text/css" rel="stylesheet" />
    <link href="{{ asset('css/bootstrap-select.min.css') }}" type="text/css" rel="stylesheet" />
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
                    <h1>Registro de Donaciones</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <p class="breadcrumb-item">Donación</p>
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

                            <div class="card-body">

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Tipo de Bien:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="select-tipo">
                                            <option value="0" disabled selected>Seleccione una opción...</option>
                                            <option value="1">Muebles</option>
                                            <option value="2">Inmuebles</option>
                                            <option value="3">Vehículos y Maquinaria</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Institución / Entidad:</label>
                                    <div class="col-sm-8">
                                        <input id="institucion" class="form-control" type="text" value="" maxlength="450">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nombre y/o Descripción del Bien:</label>
                                    <div class="col-sm-8">
                                        <input name="descripcion" id="descripcion" class="form-control" type="text" value="" autocomplete="off">
                                        <div id="countryList" style="position: absolute; z-index: 9;">
                                        </div>
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

                                <br>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Documentación:</label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-file"></i></span>
                                            </div>
                                            <input type="file" style="color:#191818; width: 80%" id="documento" accept="image/jpeg, image/jpg, image/png, .pdf"/>
                                        </div>
                                    </div>
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
    <script src="{{ asset('js/bootstrap-select.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            document.getElementById("divcontenedor").style.display = "block";

            window.idGlobalBienDonacion = 0;

            $('#descripcion').keyup(function(){

                var tipo = document.getElementById("select-tipo").value;
                var query = $(this).val();

                if(tipo == '0'){
                    toastr.error('seleccionar Tipo de Bien');
                    return;
                }

                else if(tipo == '1'){

                    if(query != ''){
                        axios.post(url+'/donacion/buscar/bien/mueble', {
                            'query' : query
                        })
                            .then((response) => {

                                $('#countryList').fadeIn();
                                $('#countryList').html(response.data);

                                if(response.data == ''){
                                    idGlobalBienDonacion = 0;
                                }
                            })
                            .catch((error) => {
                            });
                    }else{
                        idGlobalBienDonacion = 0;
                    }
                }

                else if(tipo == '2'){

                    if(query != ''){
                        axios.post(url+'/donacion/buscar/bien/inmueble', {
                            'query' : query
                        })
                            .then((response) => {

                                $('#countryList').fadeIn();
                                $('#countryList').html(response.data);

                                if(response.data == ''){
                                    idGlobalBienDonacion = 0;
                                }
                            })
                            .catch((error) => {
                            });
                    }else{
                        idGlobalBienDonacion = 0;
                    }
                }

                else if(tipo == '3'){

                    if(query != ''){
                        axios.post(url+'/donacion/buscar/bien/maquinaria', {
                            'query' : query
                        })
                            .then((response) => {

                                $('#countryList').fadeIn();
                                $('#countryList').html(response.data);

                                if(response.data == ''){
                                    idGlobalBienDonacion = 0;
                                }
                            })
                            .catch((error) => {
                            });
                    }else{
                        idGlobalBienDonacion = 0;
                    }
                }

                else{
                    idGlobalBienDonacion = 0;
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
    </script>

    <script>

        function modificarValor(id) {
            idGlobalBienDonacion = id;
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
            var institucion = document.getElementById("institucion").value;
            var descripcion = document.getElementById("descripcion").value;
            var fecha = document.getElementById("fecha").value;
            var observaciones = document.getElementById("observaciones").value;
            var documento = document.getElementById('documento');
            var tipo = document.getElementById("select-tipo").value;

            if(tipo == '0'){
                toastr.error('seleccionar Tipo de Bien');
                return;
            }

            if(institucion.length > 0){
                if(institucion.length > 450){
                    toastr.error('máximo 450 caracteres para institución');
                    return;
                }
            }

            if(observaciones.length > 0){
                if(observaciones.length > 450){
                    toastr.error('máximo 450 caracteres para observaciones');
                    return;
                }
            }

            if(documento.files && documento.files[0]){ // si trae doc
                if (!documento.files[0].type.match('image/jpeg|image/jpeg|image/png|pdf')){
                    toastr.error('formato de documento permitido: .png .jpg .jpeg .pdf');
                    return;
                }
            }

            openLoading();
            var formData = new FormData();
            formData.append('institucion', institucion);
            formData.append('descripcion', descripcion);
            formData.append('documento', documento.files[0]);
            formData.append('fecha', fecha);
            formData.append('observaciones', observaciones);
            formData.append('tipo', tipo);
            formData.append('id', idGlobalBienDonacion);

            axios.post(url+'/donacion/nuevo', formData, {
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
                    window.location.href="{{ url('/admin/donacion/index') }}";
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
