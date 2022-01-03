<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <img src="{{ asset('images/icono-sistema.png') }}" alt="Logo" class="brand-image img-circle elevation-3" >
        <span class="brand-text font-weight" style="color: white">ACTIVO</span>
    </a>

    <div class="sidebar">

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">


             <li class="nav-item">

                 <a href="#" class="nav-link">
                    <i class="far fa-edit"></i>
                    <p>
                        Roles y Permisos
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>

                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.roles.index') }}" target="frameprincipal" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Roles</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.permisos.index') }}" target="frameprincipal" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Permisos</p>
                        </a>
                    </li>

                </ul>
             </li>

            <li class="nav-item">
                <a href="{{ route('admin.vista.principal') }}" target="frameprincipal" class="nav-link">
                    <i class="fas fa-home nav-icon"></i>
                    <p>Principal</p>
                </a>
            </li>

                <li class="nav-item">

                    <a href="#" class="nav-link">
                        <i class="fas fa-book"></i>
                        <p>
                            Bienes
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.bienes.muebles.index') }}" target="frameprincipal" class="nav-link">
                                <i class="fas fa-briefcase nav-icon"></i>
                                <p>Bienes Muebles</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.bienes.inmuebles.index') }}" target="frameprincipal" class="nav-link">
                                <i class="fas fa-archive nav-icon"></i>
                                <p>Inmuebles</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.bienes.vehiculo.index') }}" target="frameprincipal" class="nav-link">
                                <i class="fas fa-car nav-icon"></i>
                                <p>Vehiculos y Maquinaria</p>
                            </a>
                        </li>

                    </ul>
                </li>


                <li class="nav-item">

                    <a href="#" class="nav-link">
                        <i class="fas fa-book"></i>
                        <p>
                       Calculos
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.calculos.depreciacion.index') }}" target="frameprincipal" class="nav-link">
                                <i class="fas fa-briefcase nav-icon"></i>
                                <p>Depreciación</p>
                            </a>
                        </li>

                    </ul>
                </li>


                <li class="nav-item">

                    <a href="#" class="nav-link">
                        <i class="fas fa-print"></i>
                        <p>
                            Reportes
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="#" target="frameprincipal" class="nav-link">
                                <i class="fas fa-file-pdf nav-icon"></i>
                                <p>Reporte por Departamento</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" target="frameprincipal" class="nav-link">
                                <i class="fas fa-file-pdf nav-icon"></i>
                                <p>Reporte de Inv.</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" target="frameprincipal" class="nav-link">
                                <i class="fas fa-file-pdf nav-icon"></i>
                                <p>Reporte de Comodato</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" target="frameprincipal" class="nav-link">
                                <i class="fas fa-file-pdf nav-icon"></i>
                                <p>Reporte de Descargos</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" target="frameprincipal" class="nav-link">
                                <i class="fas fa-file-pdf nav-icon"></i>
                                <p>Reporte de Ventas</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" target="frameprincipal" class="nav-link">
                                <i class="fas fa-file-pdf nav-icon"></i>
                                <p>Reporte de Donaciones</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" target="frameprincipal" class="nav-link">
                                <i class="fas fa-file-pdf nav-icon"></i>
                                <p>Reporte de Reevaluos</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" target="frameprincipal" class="nav-link">
                                <i class="fas fa-file-pdf nav-icon"></i>
                                <p>Reporte por Descriptor</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" target="frameprincipal" class="nav-link">
                                <i class="fas fa-file-pdf nav-icon"></i>
                                <p>Reporte por Códigos</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" target="frameprincipal" class="nav-link">
                                <i class="fas fa-file-pdf nav-icon"></i>
                                <p>Reporte de Rep. Vital</p>
                            </a>
                        </li>

                    </ul>
                </li>


                <li class="nav-item">

                    <a href="#" class="nav-link">
                        <i class="fas fa-cogs"></i>
                        <p>
                            Configuración
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.departamentos.index') }}" target="frameprincipal" class="nav-link">
                                <i class="fas fa-clipboard nav-icon"></i>
                                <p>Departamentos</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.descriptor.index') }}" target="frameprincipal" class="nav-link">
                                <i class="fas fa-clipboard nav-icon"></i>
                                <p>Descriptor</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.codcontable.index') }}" target="frameprincipal" class="nav-link">
                                <i class="fas fa-clipboard nav-icon"></i>
                                <p>Código Contable</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.codigodepreciacion.index') }}" target="frameprincipal" class="nav-link">
                                <i class="fas fa-clipboard nav-icon"></i>
                                <p>Código Depreciación</p>
                            </a>
                        </li>

                    </ul>
                </li>




            </ul>
        </nav>




    </div>
</aside>






