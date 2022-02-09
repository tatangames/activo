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
                    <h1>NUEVO INGRESO</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.bienes.inmuebles.index') }}">Bienes Inmuebles</a></li>
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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label>Código *</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-edit"></i></span>
                                                </div>
                                                <input type="text" class="form-control" maxlength="9" id="codigo" value="{{ $codigo }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Descripción *</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-edit"></i></span>
                                                </div>
                                                <textarea type="text" class="form-control" maxlength="5000" id="descripcion" rows="2" cols="50"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Valor</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                                </div>
                                                <input type="number" class="form-control" maxlength="9" id="valor">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Ubicación</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-edit"></i></span>
                                                </div>
                                                <textarea type="text" class="form-control" maxlength="1000" id="ubicacion" rows="2" cols="50"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label># de Inscripción CNR:</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-edit"></i></span>
                                                </div>
                                                <input type="text" class="form-control" maxlength="100" id="inscrito">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Valor Registrado</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                                                </div>
                                                <input type="number" maxlength="9" class="form-control" id="valorregistrado">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Observaciones</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-eye"></i></span>
                                                </div>
                                                <textarea type="text" class="form-control" maxlength="2000" id="observaciones" rows="2" cols="50"></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="card">
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label>Fecha de Compra</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="date" class="form-control" id="fechacompra">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Contiene</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-edit"></i></span>
                                                </div>
                                                <textarea type="text" class="form-control" maxlength="800" id="contiene" rows="2" cols="50"></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Edificaciones</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                </div>
                                                <input type="number" maxlength="9" class="form-control" id="edificaciones">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Fecha Permuta</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="date" class="form-control" id="fechapermuta">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label>Documento</label>
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
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" onclick="salir()" class="btn btn-default">Cancelar</button>
                    <button type="button" onclick="verificar()" class="btn btn-success">Guardar</button>
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
                    crearRegistro();
                }
            })
        }

        function crearRegistro(){
            var codigo = document.getElementById('codigo').value;
            var descripcion = document.getElementById('descripcion').value;
            var valor = document.getElementById('valor').value;
            var ubicacion = document.getElementById('ubicacion').value;
            var inscrito = document.getElementById('inscrito').value;
            var valorregistrado = document.getElementById('valorregistrado').value;
            var observaciones = document.getElementById('observaciones').value;
            var fechacompra = document.getElementById('fechacompra').value;
            var contiene = document.getElementById('contiene').value;
            var edificaciones = document.getElementById('edificaciones').value;
            var fechapermuta = document.getElementById('fechapermuta').value;
            var documento = document.getElementById('documento');

            if(codigo === ''){
                toastr.error('código es requerido');
                return;
            }

            if(descripcion === ''){
                toastr.error('Descripción es requerida');
                return;
            }

            if(descripcion.length > 5000){
                toastr.error('descripción máximo 5000 caracteres');
                return;
            }

            var reglaNumeroDecimal = /^[0-9]\d*(\.\d+)?$/;

            if(valor.length > 0) {
                if (!valor.match(reglaNumeroDecimal)) {
                    toastr.error('valor debe ser número Decimal');
                    return;
                }

                if (valor < 0) {
                    toastr.error('valor no permite números negativos');
                    return;
                }

                if (valor.length > 10) {
                    toastr.error('valor máximo 10 digitos de límite');
                    return;
                }
            }else{
                valor = 0;
            }

            if(ubicacion.length > 0){
                if(ubicacion.length > 1000){
                    toastr.error('ubicación máximo 1000 caracteres');
                    return;
                }
            }

            if(inscrito.length > 0){
                if(inscrito.length > 100){
                    toastr.error('inscrito máximo 100 caracteres');
                    return;
                }
            }

            if(valorregistrado.length > 0) {
                if (!valorregistrado.match(reglaNumeroDecimal)) {
                    toastr.error('valor registrado debe ser número Decimal');
                    return;
                }

                if (valorregistrado < 0) {
                    toastr.error('valor registrado no permite números negativos');
                    return;
                }

                if (valorregistrado.length > 10) {
                    toastr.error('valor registrado máximo 10 digitos de límite');
                    return;
                }
            }else{
                valorregistrado = 0;
            }

            if(observaciones.length > 0){
                if(observaciones.length > 2000){
                    toastr.error('observaciones máximo 2000 caracteres');
                    return;
                }
            }

            if(contiene.length > 0){
                if(contiene.length > 800){
                    toastr.error('Contiene debe llevar máximo 800 caracteres');
                    return;
                }
            }

            if(edificaciones.length > 0) {
                if (!edificaciones.match(reglaNumeroDecimal)) {
                    toastr.error('edificaciones debe ser número Decimal');
                    return;
                }

                if (edificaciones < 0) {
                    toastr.error('edificaciones no permite números negativos');
                    return;
                }

                if (edificaciones.length > 10) {
                    toastr.error('edificaciones máximo 10 digitos de límite');
                    return;
                }
            }else{
                edificaciones = 0;
            }


            if(documento.files && documento.files[0]){ // si trae doc
                if (!documento.files[0].type.match('image/jpeg|image/jpeg|image/png|pdf')){
                    toastr.error('formato de documento permitido: .png .jpg .jpeg .pdf');
                    return;
                }
            }

            openLoading();
            var formData = new FormData();
            formData.append('codigo', codigo);
            formData.append('documento', documento.files[0]);
            formData.append('descripcion', descripcion);
            formData.append('valor', valor);
            formData.append('ubicacion', ubicacion);
            formData.append('inscrito', inscrito);
            formData.append('valorregistrado', valorregistrado);
            formData.append('observaciones', observaciones);
            formData.append('fechacompra', fechacompra);
            formData.append('contiene', contiene);
            formData.append('edificaciones', edificaciones);
            formData.append('fechapermuta', fechapermuta);

            axios.post(url+'/bienes/inmuebles/nuevo', formData, {
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
                        toastr.error('el código a registrar ya existe');
                    }
                    else if(response.data.success === 2){
                        $('#modalAgregar').modal('hide');
                        toastr.success('Registrado correctamente');
                        limpiarCampos(response.data.codigo);
                    } else{
                        toastr.error('Error al Registrar');
                    }
                })
                .catch((error) => {
                    closeLoading();
                    toastr.error('Error al Registrar');
                });
        }

        function limpiarCampos(codigo){
            document.getElementById('codigo').value = codigo;
            document.getElementById('descripcion').value = "";
            document.getElementById('valor').value = "";
            document.getElementById('ubicacion').value = "";
            document.getElementById('inscrito').value = "";
            document.getElementById('valorregistrado').value = "";
            document.getElementById('observaciones').value = "";
            document.getElementById('fechacompra').value = "";
            document.getElementById('contiene').value = "";
            document.getElementById('edificaciones').value = "";
            document.getElementById('fechapermuta').value = "";
            document.getElementById('documento').value = "";
        }

        function salir(){
            window.location.href="{{ url('/admin/nuevo/bien/index') }}";
        }

    </script>


@endsection
