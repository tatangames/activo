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
                        <li class="breadcrumb-item"><a href="{{ route('admin.bienes.vehiculo.index') }}">Bienes Vehículo y Maquinaria</a></li>
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
                                            <label>Código</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-edit"></i></span>
                                                </div>
                                                <input type="text" class="form-control" maxlength="9" id="codigo" value="{{ $codigo }}">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Descripción</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-edit"></i></span>
                                                </div>
                                                <input type="text" class="form-control" maxlength="5000" id="descripcion">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Valor</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                                </div>
                                                <input type="number" class="form-control" id="valor">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Departamento</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                </div>
                                                <select class="form-control" id="select-departamento">
                                                    <option value="0">------------------</option>
                                                    @foreach($departamento as $item)
                                                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Placa</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                                </div>
                                                <input type="text" class="form-control" maxlength="50" id="placa">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Motorista</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input type="text" class="form-control" maxlength="150" id="motorista">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label>Código Contable</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                </div>
                                                <select class="form-control" id="select-codcontable">
                                                    <option value="0">------------------</option>
                                                    @foreach($codcontable as $item)
                                                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Código Depreciación</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-arrow-down"></i></span>
                                                </div>
                                                <select class="form-control" id="select-coddepreciacion">
                                                    <option value="0">------------------</option>
                                                    @foreach($coddepreciacion as $item)
                                                        <option value="{{$item->id}}">{{$item->nombre}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Vida Util (Años)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-chart-line"></i></span>
                                                </div>
                                                <input type="number" class="form-control" maxlength="9" id="vidautil">
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
                                            <label>Año</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-chart-line"></i></span>
                                                </div>
                                                <input type="number" class="form-control" maxlength="9" id="anio">
                                            </div>
                                        </div>


                                        <div class="form-group">
                                            <label>Fecha de Vec. Tarjeta</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                                </div>
                                                <input type="date" class="form-control" id="vectarjeta">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Encargado</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                                                </div>
                                                <input type="text" class="form-control" maxlength="150" id="encargado">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Valor Residual</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                                                </div>
                                                <input type="number" class="form-control" maxlength="9" id="valorresidual">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Tipo Compra</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-shopping-cart"></i></span>
                                                </div>
                                                <select class="form-control" id="select-tipocompra">
                                                    <option value="1">Nuevo</option>
                                                    <option value="2">Usado</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Observaciones</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-comment-alt"></i></span>
                                                </div>
                                                <input type="text" class="form-control" maxlength="2000" id="observaciones">
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
                <div class="card-footer">
                    <button type="button" onclick="verificar()" class="btn btn-success float-right">Guardar</button>
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
            var departamento = document.getElementById('select-departamento').value;
            var placa = document.getElementById('placa').value;
            var motorista = document.getElementById('motorista').value;
            var codcontable = document.getElementById('select-codcontable').value;
            var coddepreciacion = document.getElementById('select-coddepreciacion').value;
            var vidautil = document.getElementById('vidautil').value;
            var fechacompra = document.getElementById('fechacompra').value;
            var anio = document.getElementById('anio').value;
            var vectarjeta = document.getElementById('vectarjeta').value;
            var encargado = document.getElementById('encargado').value;
            var valorresidual = document.getElementById('valorresidual').value;
            var tipocompra = document.getElementById('select-tipocompra').value;
            var observaciones = document.getElementById('observaciones').value;

            var documento = document.getElementById('documento');

            if(codigo === ''){
                toastr.error('código es requerido');
                return;
            }

            if(descripcion.length > 0){
                if(descripcion.length > 5000){
                    toastr.error('descripción máximo 5000 caracteres');
                    return;
                }
            }

            var reglaNumeroDecimal = /^[0-9]\d*(\.\d+)?$/;
            var reglaNumeroEntero = /^[0-9]\d*$/;

            if(valor.length > 0){
                if(!valor.match(reglaNumeroDecimal)) {
                    toastr.error('valor debe ser número Decimal');
                    return;
                }

                if(valor < 0){
                    toastr.error('valor no permite números negativos');
                    return;
                }

                if(valor.length > 9){
                    toastr.error('valor máximo 9 digitos de límite');
                    return;
                }
            }

            if(departamento == '0'){
                toastr.error('Seleccionar departamento');
                return;
            }

            if(placa.length > 0){
                if(placa.length > 50){
                    toastr.error('placa máximo 50 caracteres');
                    return;
                }
            }

            if(motorista.length > 0){
                if(motorista.length > 150){
                    toastr.error('motorista máximo 150 caracteres');
                    return;
                }
            }

            if(codcontable == '0'){
                toastr.error('Seleccionar código contable');
                return;
            }

            if(coddepreciacion == '0'){
                toastr.error('Seleccionar código depreciación');
                return;
            }

            if(vidautil.length > 0){
                if(!vidautil.match(reglaNumeroEntero)) {
                    toastr.error('vida util debe ser número Entero');
                    return;
                }

                if(vidautil < 0){
                    toastr.error('vida util no permite números negativos');
                    return;
                }

                if(vidautil.length > 9){
                    toastr.error('vida util máximo 9 digitos de límite');
                    return;
                }
            }

            if(anio.length > 0){
                if(!anio.match(reglaNumeroEntero)) {
                    toastr.error('año debe ser número Entero');
                    return;
                }

                if(anio < 0){
                    toastr.error('año no permite números negativos');
                    return;
                }

                if(anio.length > 9){
                    toastr.error('año máximo 9 digitos de límite');
                    return;
                }
            }

            if(encargado.length > 0){
                if(encargado.length > 150){
                    toastr.error('encargado máximo 150 caracteres');
                    return;
                }
            }

            if(valorresidual.length > 0){
                if(!valorresidual.match(reglaNumeroEntero)) {
                    toastr.error('valor residual debe ser número Entero');
                    return;
                }

                if(valorresidual < 0){
                    toastr.error('valor residual no permite números negativos');
                    return;
                }

                if(valorresidual.length > 9){
                    toastr.error('valor residual máximo 9 digitos de límite');
                    return;
                }
            }

            if(observaciones.length > 0){
                if(observaciones.length > 2000){
                    toastr.error('observación máximo 2000 caracteres');
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

            formData.append('documento', documento.files[0]);
            formData.append('descripcion', descripcion);
            formData.append('valor', valor);
            formData.append('departamento', departamento);
            formData.append('placa', placa);
            formData.append('motorista', motorista);
            formData.append('codcontable', codcontable);
            formData.append('coddepreciacion', coddepreciacion);
            formData.append('vidautil', vidautil);
            formData.append('fechacompra', fechacompra);
            formData.append('anio', anio);
            formData.append('vectarjeta', vectarjeta);
            formData.append('encargado', encargado);
            formData.append('valorresidual', valorresidual);
            formData.append('tipocompra', tipocompra);
            formData.append('observaciones', observaciones);

            axios.post(url+'/bienes/vehiculo/nuevo', formData, {
            })
                .then((response) => {
                    closeLoading();

                    if(response.data.success === 1){
                        toastr.error('El código a registrar ya existe');
                    }
                    else if(response.data.success === 2){
                        $('#modalAgregar').modal('hide');
                        toastr.success('Registrado correctamente');
                        limpiarCampos();
                    } else{
                        toastr.error('Error al Registrar');
                    }
                })
                .catch((error) => {
                    closeLoading();
                    toastr.error('Error al Registrar');
                });
        }

        function limpiarCampos(){
            document.getElementById('descripcion').value = "";
            document.getElementById('valor').value = "";
            document.getElementById('select-departamento').options.selectedIndex = 0;
            document.getElementById('placa').value = "";
            document.getElementById('motorista').value = "";
            document.getElementById('select-codcontable').options.selectedIndex = 0;
            document.getElementById('select-coddepreciacion').options.selectedIndex = 0;
            document.getElementById('vidautil').value = "";
            document.getElementById('fechacompra').value = "";
            document.getElementById('anio').value = "";
            document.getElementById('vectarjeta').value = "";
            document.getElementById('encargado').value = "";
            document.getElementById('valorresidual').value = "";
            document.getElementById('observaciones').value = "";
            document.getElementById('documento').value = "";
        }

    </script>


@endsection
