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
                        <li class="breadcrumb-item"><a href="{{ route('admin.bienes.muebles.index') }}">Bienes Muebles</a></li>
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
                                            <label>Descripción</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-edit"></i></span>
                                                </div>
                                                <input type="text" class="form-control" maxlength="2000" id="descripcion">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Valor</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                                </div>
                                                <input type="number" class="form-control" id="valor" onchange="comprobar(this)">
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
                                            <label>Código Contable</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                </div>
                                                <select class="form-control" id="select-codcontable" disabled>
                                                    <option value="0">------------------</option>
                                                    @foreach($codcontable as $item)
                                                        <option value="{{$item->id}}">{{$item->nombre}} {{ $item->codconta }}</option>
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
                                                <select class="form-control" id="select-coddepreciacion" disabled>
                                                    <option value="0">------------------</option>
                                                    @foreach($coddepreciacion as $item)
                                                        <option value="{{$item->id}}">{{$item->nombre}} {{ $item->coddepre }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Valor Residual</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-hand-holding-usd"></i></span>
                                                </div>
                                                <input type="number" class="form-control" id="valorresidual" disabled>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Tipo Compra</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-shopping-cart"></i></span>
                                                </div>
                                                <select class="form-control" id="select-tipocompra" disabled>
                                                    <option value="0">------------------</option>
                                                    <option value="1">Nuevo</option>
                                                    <option value="2">Usado</option>
                                                </select>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="card">
                                    <div class="card-body">

                                        <div class="form-group">
                                            <label>Código Descriptor</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-arrow-down"></i></span>
                                                </div>
                                                <select class="form-control" id="select-coddescriptor">
                                                    <option value="0">------------------</option>
                                                    @foreach($coddescriptor as $item)
                                                        <option value="{{$item->id}}">{{$item->descripcion}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

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
                                            <label>Vida Util (Años)</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-chart-line"></i></span>
                                                </div>
                                                <input type="number" class="form-control" id="vidautil">
                                            </div>
                                        </div>



                                        <div class="form-group">
                                            <label>Observaciones</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-comment-alt"></i></span>
                                                </div>
                                                <textarea type="text" rows="2" cols="50" class="form-control" maxlength="20000" id="observaciones"> </textarea>
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

                                        <div class="form-group">
                                            <label>Factura</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-file"></i></span>
                                                </div>
                                                <input type="file" style="color:#191818; width: 80%" id="factura" accept="image/jpeg, image/jpg, image/png, .pdf"/>
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

        function comprobar(dato){
            var reglaNumeroDecimal = /^[0-9]\d*(\.\d+)?$/;
            var valor = dato.value;

            if(valor.length > 0){
                if(!valor.match(reglaNumeroDecimal)) {
                    toastr.error('valor debe ser número Decimal');
                    return;
                }

                if(valor < 0){
                    toastr.error('valor no permite números negativos');
                    return;
                }

                if(valor.length > 7){
                    toastr.error('valor máximo 7 digitos de límite');
                    return;
                }

                if(valor >= 600){
                    document.getElementById('select-codcontable').disabled = false;
                    document.getElementById('select-tipocompra').disabled = false;
                    document.getElementById('select-coddepreciacion').disabled = false;
                    document.getElementById('valorresidual').disabled = false;
                }else{
                    document.getElementById('select-codcontable').disabled = true;
                    document.getElementById('select-tipocompra').disabled = true;
                    document.getElementById('select-coddepreciacion').disabled = true;
                    document.getElementById('valorresidual').disabled = true;
               }
            }else{
                document.getElementById('select-codcontable').disabled = true;
                document.getElementById('select-tipocompra').disabled = true;
                document.getElementById('select-coddepreciacion').disabled = true;
                document.getElementById('valorresidual').disabled = true;
            }
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
                    crearRegistro();
                }
            })
        }

        function crearRegistro(){
            var descripcion = document.getElementById('descripcion').value;
            var valor = document.getElementById('valor').value;
            var departamento = document.getElementById('select-departamento').value;
            var codcontable = document.getElementById('select-codcontable').value;
            var coddepreciacion = document.getElementById('select-coddepreciacion').value;
            var coddescriptor = document.getElementById('select-coddescriptor').value;
            var fechacompra = document.getElementById('fechacompra').value;
            var vidautil = document.getElementById('vidautil').value;
            var valorresidual = document.getElementById('valorresidual').value;
            var tipocompra = document.getElementById('select-tipocompra').value;
            var observaciones = document.getElementById('observaciones').value;
            var documento = document.getElementById('documento');
            var factura = document.getElementById('factura');

            var valorContable = 1;
            var valorDepre = 1;
            var datoResidual = 0;
            var valorTipoCompra = 1;

            if(descripcion.length > 0){
                if(descripcion.length > 2000){
                    toastr.error('descripción máximo 2000 caracteres');
                    return;
                }
            }

            if(departamento == '0'){
                toastr.error('Seleccionar departamento');
                return;
            }

            if(coddescriptor == '0'){
                toastr.error('Seleccionar descriptor');
                return;
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

                if(valor.length > 7){
                    toastr.error('valor máximo 7 digitos de límite');
                    return;
                }

                if(valor >= 600){
                    // verificar que se haya seleccionado
                    if(codcontable == '0'){
                        toastr.error('Seleccionar código contable');
                        return;
                    }

                    if(coddepreciacion == '0'){
                        toastr.error('Seleccionar código depreciación');
                        return;
                    }

                    if(tipocompra == '0'){
                        toastr.error('Seleccionar tipo de compra');
                        return;
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

                        if(valorresidual.length > 7){
                            toastr.error('valor residual máximo 7 digitos de límite');
                            return;
                        }

                        // obtener valor
                        datoResidual = valorresidual;
                        valorContable = codcontable;
                        valorDepre = coddepreciacion;
                        valorTipoCompra = tipocompra;
                    }

                }
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

                if(vidautil.length > 7){
                    toastr.error('vida util máximo 7 digitos de límite');
                    return;
                }
            }

            if(observaciones.length > 0){
                if(observaciones.length > 20000){
                    toastr.error('observación máximo 20000 caracteres');
                    return;
                }
            }

            if(documento.files && documento.files[0]){ // si trae doc
                if (!documento.files[0].type.match('image/jpeg|image/jpeg|image/png|pdf')){
                    toastr.error('formato de documento permitido: .png .jpg .jpeg .pdf');
                    return;
                }
            }

            if(factura.files && factura.files[0]){ // si trae factura
                if (!factura.files[0].type.match('image/jpeg|image/jpeg|image/png|pdf')){
                    toastr.error('formato de factura permitido: .png .jpg .jpeg .pdf');
                    return;
                }
            }

            openLoading();
            var formData = new FormData();

            formData.append('documento', documento.files[0]);
            formData.append('factura', factura.files[0]);
            formData.append('descripcion', descripcion);
            formData.append('valor', valor);
            formData.append('departamento', departamento);
            formData.append('codcontable', valorContable);
            formData.append('coddepreciacion', valorDepre);
            formData.append('coddedescriptor', coddescriptor);
            formData.append('vidautil', vidautil);
            formData.append('fechacompra', fechacompra);
            formData.append('valorresidual', datoResidual);
            formData.append('tipocompra', valorTipoCompra);
            formData.append('observaciones', observaciones);

            axios.post(url+'/bienes/muebles/nuevo', formData, {
            })
                .then((response) => {
                    closeLoading();
                    if(response.data.success === 1){
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
            document.getElementById('select-codcontable').options.selectedIndex = 0;
            document.getElementById('select-coddepreciacion').options.selectedIndex = 0;
            document.getElementById('select-coddescriptor').options.selectedIndex = 0;
            document.getElementById('vidautil').value = "";
            document.getElementById('fechacompra').value = "";
            document.getElementById('valorresidual').value = "";
            document.getElementById('observaciones').value = "";
            document.getElementById('documento').value = "";
            document.getElementById('factura').value = "";
        }

    </script>


@endsection
