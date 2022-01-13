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
                    <h1>Registro de Traslado</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Traslado</li>
                        <li class="breadcrumb-item active">Registro</li>
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
                                    <label class="col-sm-2 col-form-label">Del Departamento:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="select-envia">
                                            @foreach($departamento as $item)
                                                <option value="{{$item->id}}">{{$item->codigo}} - {{$item->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Hacia el Departamento:</label>
                                    <div class="col-sm-8">
                                        <select class="form-control" id="select-recibe">
                                            @foreach($departamento as $item)
                                                <option value="{{$item->id}}">{{$item->codigo}} - {{$item->nombre}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Fecha de Traslado:</label>

                                    <div class="col-sm-3">
                                        <input type="date" class="form-control" id="fecha">
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

            window.idGlobalBien = 0;

            $('#descripcion').keyup(function(){

                var tipo = document.getElementById("select-tipo").value;
                var query = $(this).val();

                if(tipo == '0'){
                    toastr.error('seleccionar Tipo de Bien');
                    return;
                }

                else if(tipo == '1'){

                    if(query != ''){
                        axios.post(url+'/traslado/buscar/bien/mueble', {
                            'query' : query
                        })
                            .then((response) => {

                                $('#countryList').fadeIn();
                                $('#countryList').html(response.data);

                                if(response.data == ''){
                                    idGlobalBien = 0;
                                }
                            })
                            .catch((error) => {
                            });
                    }else{
                        idGlobalBien = 0;
                    }
                }

                else if(tipo == '2'){

                    if(query != ''){
                        axios.post(url+'/traslado/buscar/bien/maquinaria', {
                            'query' : query
                        })
                            .then((response) => {

                                $('#countryList').fadeIn();
                                $('#countryList').html(response.data);

                                if(response.data == ''){
                                    idGlobalBien = 0;
                                }
                            })
                            .catch((error) => {
                            });
                    }else{
                        idGlobalBien = 0;
                    }
                }else{
                    idGlobalBien = 0;
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
        function modificarValor(id,depto) {
            idGlobalBien = id;
            $('#select-envia').val(depto);
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
            var envia = document.getElementById("select-envia").value;
            var recibe = document.getElementById("select-recibe").value;
            var fecha = document.getElementById("fecha").value;
            var tipo = document.getElementById("select-tipo").value;

            if(tipo == '0'){
                toastr.error('seleccionar Tipo de Bien');
                return;
            }

            openLoading();
            var formData = new FormData();
            formData.append('idglobal', idGlobalBien);
            formData.append('tipo', tipo);
            formData.append('fecha', fecha);
            formData.append('envia', envia);
            formData.append('recibe', recibe);

            axios.post(url+'/traslado/nuevo', formData, {
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
                    window.location.href="{{ url('/admin/traslado/index') }}";
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
