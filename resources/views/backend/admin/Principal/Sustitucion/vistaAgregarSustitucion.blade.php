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
                    <h1>Registro de Sustitución</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <p class="breadcrumb-item">Reposición Vital</p>
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
                                <label class="col-sm-2 col-form-label">Valor de la pieza sustituida:</label>

                                <div class="col-sm-3">
                                    <input type="number" value="0.00" class="form-control" id="piezasustituida">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Valor de la pieza Nueva:</label>

                                <div class="col-sm-3">
                                    <input type="number" value="0.00" class="form-control" id="piezanueva">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Vida Util agregada (Años):</label>

                                <div class="col-sm-3">
                                    <input type="number" value="0" class="form-control" id="vidautil">
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

            window.idGlobalBienSustitucion = 0;

            $('#descripcion').keyup(function(){

                var tipo = document.getElementById("select-tipo").value;
                var query = $(this).val();

                if(tipo == '0'){
                    toastr.error('seleccionar Tipo de Bien');
                    return;
                }

                else if(tipo == '1'){

                    if(query != ''){
                        axios.post(url+'/sustitucion/buscar/bien/mueble', {
                            'query' : query
                        })
                            .then((response) => {

                                $('#countryList').fadeIn();
                                $('#countryList').html(response.data);

                                if(response.data == ''){
                                    idGlobalBienSustitucion = 0;
                                }
                            })
                            .catch((error) => {
                            });
                    }else{
                        idGlobalBienSustitucion = 0;
                    }
                }

                else if(tipo == '2'){

                    if(query != ''){
                        axios.post(url+'/sustitucion/buscar/bien/maquinaria', {
                            'query' : query
                        })
                            .then((response) => {

                                $('#countryList').fadeIn();
                                $('#countryList').html(response.data);

                                if(response.data == ''){
                                    idGlobalBienSustitucion = 0;
                                }
                            })
                            .catch((error) => {
                            });
                    }else{
                        idGlobalBienSustitucion = 0;
                    }
                }else{
                    idGlobalBienSustitucion = 0;
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
        function modificarValor(id) {
            idGlobalBienSustitucion = id;
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

            var piezasustituida = document.getElementById("piezasustituida").value;
            var piezanueva = document.getElementById("piezanueva").value;
            var vidautil = document.getElementById("vidautil").value;
            var fecha = document.getElementById("fecha").value;
            var observaciones = document.getElementById("observaciones").value;
            var documento = document.getElementById('documento');

            if(tipo == '0'){
                toastr.error('seleccionar Tipo de Bien');
                return;
            }

            var reglaNumeroDecimal = /^[0-9]\d*(\.\d+)?$/;
            var reglaNumeroEntero = /^[0-9]\d*$/;

            if(piezasustituida.length > 0){

                if(!piezasustituida.match(reglaNumeroDecimal)) {
                    toastr.error('Pieza Sustituida debe ser número Decimal');
                    return;
                }

                if(piezasustituida < 0){
                    toastr.error('Pieza Sustituida no permite números negativos');
                    return;
                }

                if(piezasustituida.length > 9){
                    toastr.error('Pieza Sustituida máximo 9 digitos de límite');
                    return;
                }
            }


            if(piezanueva.length > 0){

                if(!piezanueva.match(reglaNumeroDecimal)) {
                    toastr.error('Pieza Nueva debe ser número Decimal');
                    return;
                }

                if(piezanueva < 0){
                    toastr.error('Pieza Nueva no permite números negativos');
                    return;
                }

                if(piezanueva.length > 9){
                    toastr.error('Pieza Nueva máximo 9 digitos de límite');
                    return;
                }
            }

            if(vidautil.length > 0){
                if(!vidautil.match(reglaNumeroEntero)) {
                    toastr.error('Vida Útil debe ser número Entero');
                    return;
                }

                if(vidautil < 0){
                    toastr.error('Vida Útil no debe ser número negativo');
                    return;
                }

                if(vidautil.length > 9){
                    toastr.error('Máximo 7 dígitos de límite para Vida Útil');
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
            formData.append('id', idGlobalBienSustitucion);
            formData.append('tipo', tipo);

            formData.append('piezasustituida', piezasustituida);
            formData.append('piezanueva', piezanueva);
            formData.append('vidautil', vidautil);
            formData.append('documento', documento.files[0]);

            formData.append('observaciones', observaciones);
            formData.append('fecha', fecha);

            axios.post(url+'/sustitucion/nuevo', formData, {
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
                    window.location.href="{{ url('/admin/sustitucion/index') }}";
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
