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

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bookmark"> NUEVO REGISTRO</i>

                    </h3>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info" style="background-color: #1ebfae !important;">
                                <i class="fas fa-plus"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size: 15px;
                                color: #31708f; font-family: 'Arial'">NUEVO BIEN</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bookmark"> NUEVO REGISTRO</i>

                    </h3>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info" style="background-color: #ffb53e !important;">
                                <i class="fas fa-retweet"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size: 15px;
                                color: #31708f; font-family: 'Arial'">TRASLADO</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info" style="background-color: #ffb53e !important;">
                                <i class="fas fa-thumbs-down"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size: 15px;
                                color: #31708f; font-family: 'Arial'">DESCARGOS</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info" style="background-color: #f9243f !important;">
                                <i class="fas fa-tag"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size: 15px;
                                color: #31708f; font-family: 'Arial'">VENTA</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info" style="background-color: #f9243f !important;">
                                <i class="fas fa-life-ring"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size: 15px;
                                color: #31708f; font-family: 'Arial'">REPOSICIÓN VITAL</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-bookmark"> BIENES INMUEBLES</i>

                    </h3>
                </div>

                <div class="row">
                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info" style="background-color: #30a5ff !important;">
                                <i class="fas fa-gift"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size: 15px;
                                color: #31708f; font-family: 'Arial'">DONACIONES</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info" style="background-color: #30a5ff !important;">
                                <i class="fas fa-handshake"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size: 15px;
                                color: #31708f; font-family: 'Arial'">COMODATOS</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12" >
                        <div class="info-box">
                            <span class="info-box-icon bg-info" style="background-color: #30a5ff !important;">
                                <i class="fas fa-car"></i></span>
                            <a href="{{ route('admin.bienes.vehiculo.index') }}" target="frameprincipal">
                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size: 15px;
                                color: #31708f; font-family: 'Arial'">VENTA VEHICULOS Y </br> MAQUINARIA</span>
                            </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-3 col-sm-6 col-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info" style="background-color: #30a5ff !important;">
                                <i class="fas fa-money-bill"></i></span>

                            <div class="info-box-content">
                                <span class="info-box-text" style="font-size: 15px;
                                color: #31708f; font-family: 'Arial'">REEVALUO</span>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>
    </section>

</div>



/

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


        });
    </script>


@endsection
