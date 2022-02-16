<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Login\LoginController;
use App\Http\Controllers\Controles\ControlController;
use App\Http\Controllers\Backend\Roles\RolesController;
use App\Http\Controllers\Backend\Roles\PermisoController;
use App\Http\Controllers\Backend\Perfil\PerfilController;
use App\Http\Controllers\Backend\Principal\PrincipalController;
use App\Http\Controllers\Backend\Departamento\DepartamentoController;
use App\Http\Controllers\Backend\Descriptor\DescriptorController;
use App\Http\Controllers\Backend\CodConta\CodigoContableController;
use App\Http\Controllers\Backend\CodDepre\CodigoDepreciacionController;
use App\Http\Controllers\Backend\Bienes\BienesVehiculoController;
use App\Http\Controllers\Backend\Bienes\BienesMueblesController;
use App\Http\Controllers\Backend\Bienes\BienesInmueblesController;
use App\Http\Controllers\Backend\Calculos\CalculoDepreciacionController;
use App\Http\Controllers\Backend\Reportes\ReportesController;
use App\Http\Controllers\Backend\Comodato\ComodatoController;
use App\Http\Controllers\Backend\Donacion\DonacionController;
use App\Http\Controllers\Backend\Traslado\TrasladoController;
use App\Http\Controllers\Backend\Venta\VentaController;
use App\Http\Controllers\Backend\Sustitucion\SustitucionController;
use App\Http\Controllers\Backend\Reevaluo\ReevaluoController;
use App\Http\Controllers\Backend\Descargo\DescargoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [LoginController::class,'index'])->name('login');

Route::post('admin/login', [LoginController::class, 'login']);
Route::post('admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

// --- CONTROL WEB ---
Route::get('/panel', [ControlController::class,'indexRedireccionamiento'])->name('admin.panel');

     // --- ROLES ---
    Route::get('/admin/roles/index', [RolesController::class,'index'])->name('admin.roles.index');
    Route::get('/admin/roles/tabla', [RolesController::class,'tablaRoles']);
    Route::get('/admin/roles/lista/permisos/{id}', [RolesController::class,'vistaPermisos']);
    Route::get('/admin/roles/permisos/tabla/{id}', [RolesController::class,'tablaRolesPermisos']);
    Route::post('/admin/roles/permiso/borrar', [RolesController::class, 'borrarPermiso']);
    Route::post('/admin/roles/permiso/agregar', [RolesController::class, 'agregarPermiso']);
    Route::get('/admin/roles/permisos/lista', [RolesController::class,'listaTodosPermisos']);
    Route::get('/admin/roles/permisos-todos/tabla', [RolesController::class,'tablaTodosPermisos']);
    Route::post('/admin/roles/borrar-global', [RolesController::class, 'borrarRolGlobal']);

    // --- PERMISOS ---
    Route::get('/admin/permisos/index', [PermisoController::class,'index'])->name('admin.permisos.index');
    Route::get('/admin/permisos/tabla', [PermisoController::class,'tablaUsuarios']);
    Route::post('/admin/permisos/nuevo-usuario', [PermisoController::class, 'nuevoUsuario']);
    Route::post('/admin/permisos/info-usuario', [PermisoController::class, 'infoUsuario']);
    Route::post('/admin/permisos/editar-usuario', [PermisoController::class, 'editarUsuario']);
    Route::post('/admin/permisos/nuevo-rol', [PermisoController::class, 'nuevoRol']);
    Route::post('/admin/permisos/extra-nuevo', [PermisoController::class, 'nuevoPermisoExtra']);
    Route::post('/admin/permisos/extra-borrar', [PermisoController::class, 'borrarPermisoGlobal']);

    // --- PERFIL ---
    Route::get('/admin/editar-perfil/index', [PerfilController::class,'indexEditarPerfil'])->name('admin.perfil');
    Route::post('/admin/editar-perfil/actualizar', [PerfilController::class, 'editarUsuario']);

    Route::get('/admin/pdf', [PerfilController::class,'pdf']);

    // --- SIN PERMISOS VISTA 403 ---
    Route::get('sin-permisos', [ControlController::class,'indexSinPermiso'])->name('no.permisos.index');

    // --- PRINCIPAL ---
    Route::get('/admin/principal/index', [PrincipalController::class,'index'])->name('admin.vista.principal');
    Route::get('/admin/nuevo/bien/index', [PrincipalController::class,'nuevoBienIndex'])->name('admin.vista.nuevo.bien.index');
    Route::get('/admin/principal/bien/muebles/', [PrincipalController::class,'vistaAgregarRegistroMueble']);
    Route::get('/admin/principal/bien/vehiculo/', [PrincipalController::class,'vistaAgregarRegistroVehiculo']);
    Route::get('/admin/principal/bien/inmuebles/', [PrincipalController::class,'vistaAgregarRegistroInmueble']);


    // --- DEPARTAMENTOS ---
    Route::get('/admin/departamento/index', [DepartamentoController::class,'index'])->name('admin.departamentos.index');
    Route::get('/admin/departamento/tabla', [DepartamentoController::class,'tablaDepartamento']);
    Route::post('/admin/departamento/nuevo', [DepartamentoController::class, 'nuevoDepartamento']);
    Route::post('/admin/departamento/informacion', [DepartamentoController::class, 'informacionDepartamento']);
    Route::post('/admin/departamento/editar', [DepartamentoController::class, 'editarDepartamento']);

    // --- DESCRIPTOR ---
    Route::get('/admin/descriptor/index', [DescriptorController::class,'index'])->name('admin.descriptor.index');
    Route::get('/admin/descriptor/tabla', [DescriptorController::class,'tablaDescriptor']);
    Route::post('/admin/descriptor/nuevo', [DescriptorController::class, 'nuevoDescriptor']);
    Route::post('/admin/descriptor/informacion', [DescriptorController::class, 'informacionDescriptor']);
    Route::post('/admin/descriptor/editar', [DescriptorController::class, 'editarDescriptor']);

    // --- CODIGO CONTABLE ---
    Route::get('/admin/codcontable/index', [CodigoContableController::class,'index'])->name('admin.codcontable.index');
    Route::get('/admin/codcontable/tabla', [CodigoContableController::class,'tablaContable']);
    Route::post('/admin/codcontable/nuevo', [CodigoContableController::class, 'nuevoCodContable']);
    Route::post('/admin/codcontable/informacion', [CodigoContableController::class, 'informacionContable']);
    Route::post('/admin/codcontable/editar', [CodigoContableController::class, 'editarContable']);

    // --- CODIGO DESPRECIACION ---
    Route::get('/admin/coddepreciacion/index', [CodigoDepreciacionController::class,'index'])->name('admin.codigodepreciacion.index');
    Route::get('/admin/coddepreciacion/tabla', [CodigoDepreciacionController::class,'tablaDepreciacion']);
    Route::post('/admin/coddepreciacion/nuevo', [CodigoDepreciacionController::class, 'nuevoCodDepreciacion']);
    Route::post('/admin/coddepreciacion/informacion', [CodigoDepreciacionController::class, 'informacionDepreciacion']);
    Route::post('/admin/coddepreciacion/editar', [CodigoDepreciacionController::class, 'editarDepreciacion']);

    // --- BIENES VEHICULOS ---
    Route::get('/admin/bienes/vehiculo/index', [BienesVehiculoController::class,'index'])->name('admin.bienes.vehiculo.index');
    Route::get('/admin/bienes/vehiculo/tabla', [BienesVehiculoController::class,'tablaRegistros']);
    Route::get('/admin/bienes/vehiculo/vista-nuevo', [BienesVehiculoController::class,'vistaAgregarRegistro']);
    Route::get('/admin/bienes/vehiculo/vista-editar/{id}', [BienesVehiculoController::class,'vistaEditarRegistro']);
    Route::post('/admin/bienes/vehiculo/nuevo', [BienesVehiculoController::class, 'nuevoBienVehiculo']);
    Route::post('/admin/bienes/vehiculo/editar', [BienesVehiculoController::class, 'editarBienVehiculo']);
    Route::get('/admin/bienes/vehiculo/doc/{file}' , [BienesVehiculoController::class, 'descargarDocumento']);

    // --- BIENES MUEBLES ---
    Route::get('/admin/bienes/muebles/index', [BienesMueblesController::class,'index'])->name('admin.bienes.muebles.index');
    Route::get('/admin/bienes/muebles/tabla', [BienesMueblesController::class,'tablaRegistros']);
    Route::get('/admin/bienes/muebles/vista-nuevo', [BienesMueblesController::class,'vistaAgregarRegistro']);
    Route::post('/admin/bienes/muebles/nuevo', [BienesMueblesController::class, 'nuevoBienMuebles']);
    Route::get('/admin/bienes/muebles/doc/{file}' , [BienesMueblesController::class, 'descargarDocumento']);
    Route::get('/admin/bienes/muebles/fac/{file}' , [BienesMueblesController::class, 'descargarFactura']);
    Route::get('/admin/bienes/muebles/vista-editar/{id}', [BienesMueblesController::class,'vistaEditarRegistro']);
    Route::post('/admin/bienes/muebles/editar', [BienesMueblesController::class, 'editarBienMuebles']);

    // --- BIENES INMUEBLES ---
    Route::get('/admin/bienes/inmuebles/index', [BienesInmueblesController::class,'index'])->name('admin.bienes.inmuebles.index');
    Route::get('/admin/bienes/inmuebles/tabla', [BienesInmueblesController::class,'tablaRegistros']);
    Route::get('/admin/bienes/inmuebles/vista-nuevo', [BienesInmueblesController::class,'vistaAgregarRegistro']);
    Route::post('/admin/bienes/inmuebles/nuevo', [BienesInmueblesController::class, 'nuevoBienInmuebles']);
    Route::get('/admin/bienes/inmuebles/doc/{file}' , [BienesInmueblesController::class, 'descargarDocumento']);
    Route::get('/admin/bienes/inmuebles/vista-editar/{id}', [BienesInmueblesController::class,'vistaEditarRegistro']);
    Route::post('/admin/bienes/inmuebles/editar', [BienesInmueblesController::class, 'editarBienInmuebles']);

    // --- CALCULOS DEPRECIACION ---
    Route::get('/admin/calculos/depreciacion/index', [CalculoDepreciacionController::class,'index'])->name('admin.calculos.depreciacion.index');

    // verificar existe codigo bienes muebles o maquinaria
    Route::post('/admin/verificar/existe-codigo', [CalculoDepreciacionController::class, 'verificarCodigo']);
    Route::get('/admin/reporte/codigo-bien/{id}/{tipo}', [CalculoDepreciacionController::class,'indexReporteCodigo']);

    Route::post('/admin/guardar/historiada/mueble', [CalculoDepreciacionController::class, 'guardarHistorialdaMueble']);
    Route::post('/admin/borrar/historiada/mueble', [CalculoDepreciacionController::class, 'borrarHistorialdaMueble']);

    Route::post('/admin/guardar/historiada/maquinaria', [CalculoDepreciacionController::class, 'guardarHistorialdaMaquinaria']);
    Route::post('/admin/borrar/historiada/maquinaria', [CalculoDepreciacionController::class, 'borrarHistorialdaMaquinaria']);


    Route::get('/admin/calculo/mueble/pdf/{id}', [CalculoDepreciacionController::class,'pdfCalculoBienMueble']);
    Route::get('/admin/calculo/maquinaria/pdf/{id}', [CalculoDepreciacionController::class,'pdfCalculoBienMaquinaria']);

    Route::get('/admin/reporte/pdf/calculo-anual/{anio}', [CalculoDepreciacionController::class,'pdfCalculoAnual']);





    // --- REPORTES VARIOS ---
    // departamento
    Route::get('/admin/reporte/departamento/index', [ReportesController::class,'indexDepartamento'])->name('admin.reporte.departamento.index');
    Route::get('/admin/reporte/pdf/departamento/{id}', [ReportesController::class,'pdfDepartamento']);

    // inventario
    Route::get('/admin/reporte/inventario/index', [ReportesController::class,'indexInventario'])->name('admin.reporte.inventario.index');

    // pdf muebles
    Route::get('/admin/generador/pdf/inventario/muebles/{valor}', [ReportesController::class,'pdfInventarioMuebles']);
    // pdf inmueble
    Route::get('/admin/generador/pdf/inventario/inmueble', [ReportesController::class,'pdfInventarioInmuebles']);
    // pdf maquinaria
    Route::get('/admin/generador/pdf/inventario/maquinaria', [ReportesController::class,'pdfInventarioMaquinaria']);

    // pdf bienes individuales
    Route::get('/admin/pdf/bien/individual/{valor}/{id}', [ReportesController::class,'pdfInventarioBienes']);
    Route::post('/admin/verificar/bienindividual/existe-codigo', [ReportesController::class, 'verificarCodigoBienIndividual']);


    // comodato
    Route::get('/admin/reporte/comodato/index', [ReportesController::class,'indexComodato'])->name('admin.reporte.comodato.index');
    Route::get('/admin/reporte/pdf/comodato/{fechainicio}/{fechafinal}/{valor}', [ReportesController::class,'pdfComodato']);

    // descargos
    Route::get('/admin/reporte/descargos/index', [ReportesController::class,'indexDescargos'])->name('admin.reporte.descargos.index');
    Route::get('/admin/reporte/pdf/descargos/{fechainicio}/{fechafinal}/{valor}', [ReportesController::class,'pdfDescargos']);

    // ventas
    Route::get('/admin/reporte/ventas/index', [ReportesController::class,'indexVentas'])->name('admin.reporte.ventas.index');
    Route::get('/admin/reporte/pdf/ventas/{fechainicio}/{fechafinal}/{valor}', [ReportesController::class,'pdfVentas']);

    // donaciones
    Route::get('/admin/reporte/donaciones/index', [ReportesController::class,'indexDonaciones'])->name('admin.reporte.donaciones.index');
    Route::get('/admin/reporte/pdf/donaciones/{fechainicio}/{fechafinal}/{valor}', [ReportesController::class,'pdfDonaciones']);

    // reevaluos
    Route::get('/admin/reporte/reevaluos/index', [ReportesController::class,'indexReevaluos'])->name('admin.reporte.reevaluos.index');
    Route::get('/admin/reporte/pdf/reevaluos/{fechainicio}/{fechafinal}', [ReportesController::class,'pdfReevaluos']);

    // descriptor
    Route::get('/admin/reporte/descriptor/index', [ReportesController::class,'indexDescriptor'])->name('admin.reporte.descriptor.index');
    Route::get('/admin/reporte/pdf/descriptor/{valor}', [ReportesController::class,'pdfDescriptor']);

    // codigo
    Route::get('/admin/reporte/codigo/index', [ReportesController::class,'indexCodigo'])->name('admin.reporte.codigo.index');
    Route::get('/admin/reporte/pdf/codigo/{fechainicio}/{fechafinal}', [ReportesController::class,'pdfCodigo']);

    // rep vital
    Route::get('/admin/reporte/repvital/index', [ReportesController::class,'indexRepvital'])->name('admin.reporte.repvital.index');
    Route::get('/admin/reporte/pdf/repvital/{fechainicio}/{fechafinal}/{valor}', [ReportesController::class,'pdfRevital']);

    // --- COMODATO ---
    Route::get('/admin/comodato/index', [ComodatoController::class,'index'])->name('admin.comodato.index');
    Route::get('/admin/comodato/tabla', [ComodatoController::class,'tablaRegistros']);
    Route::get('/admin/comodato/vista/agregar', [ComodatoController::class,'vistaAgregar']);
    Route::post('/admin/comodato/buscar/bien/mueble', [ComodatoController::class,'busquedaNombreMueble']);
    Route::post('/admin/comodato/buscar/bien/inmueble', [ComodatoController::class,'busquedaInmueble']);
    Route::post('/admin/comodato/buscar/bien/maquinaria', [ComodatoController::class,'busquedaMaquinaria']);
    Route::get('/admin/comodato/doc/{id}/{tipo}' , [ComodatoController::class, 'descargarDocumentoComodato']);
    Route::post('/admin/comodato/nuevo', [ComodatoController::class,'nuevoRegistro']);
    Route::get('/admin/comodato/vista/editar/{id}/{valor}', [ComodatoController::class,'vistaEditar']);
    Route::post('/admin/comodato/editar', [ComodatoController::class,'editarRegistro']);
    Route::post('/admin/comodato/borrar', [ComodatoController::class,'borrarRegistro']);

    // --- DONACION ---
    Route::get('/admin/donacion/index', [DonacionController::class,'index'])->name('admin.donacion.index');
    Route::get('/admin/donacion/tabla', [DonacionController::class,'tablaRegistros']);
    Route::get('/admin/donacion/vista/agregar', [DonacionController::class,'vistaAgregar']);
    Route::post('/admin/donacion/buscar/bien/mueble', [DonacionController::class,'busquedaNombreMueble']);
    Route::post('/admin/donacion/buscar/bien/inmueble', [DonacionController::class,'busquedaInmueble']);
    Route::post('/admin/donacion/buscar/bien/maquinaria', [DonacionController::class,'busquedaMaquinaria']);
    Route::get('/admin/donacion/doc/{id}/{tipo}' , [DonacionController::class, 'descargarDocumentoDonacion']);
    Route::post('/admin/donacion/nuevo', [DonacionController::class,'nuevoRegistro']);
    Route::get('/admin/donacion/vista/editar/{id}/{valor}', [DonacionController::class,'vistaEditar']);
    Route::post('/admin/donacion/editar', [DonacionController::class,'editarRegistro']);
    Route::post('/admin/donacion/borrar', [DonacionController::class,'borrarRegistro']);

    // --- TRASLADO ---
    Route::get('/admin/traslado/index', [TrasladoController::class,'index'])->name('admin.traslado.index');
    Route::get('/admin/traslado/tabla', [TrasladoController::class,'tablaRegistros']);
    Route::get('/admin/traslado/vista/agregar', [TrasladoController::class,'vistaAgregar']);
    Route::post('/admin/traslado/buscar/bien/mueble', [TrasladoController::class,'busquedaNombreMueble']);
    Route::post('/admin/traslado/buscar/bien/maquinaria', [TrasladoController::class,'busquedaMaquinaria']);
    Route::post('/admin/traslado/nuevo', [TrasladoController::class,'nuevoRegistro']);
    Route::get('/admin/traslado/vista/editar/{id}/{valor}', [TrasladoController::class,'vistaEditar']);
    Route::post('/admin/traslado/editar', [TrasladoController::class,'editarRegistro']);

    // --- VENTA ---
    Route::get('/admin/venta/index', [VentaController::class,'index'])->name('admin.venta.index');
    Route::get('/admin/venta/tabla', [VentaController::class,'tablaRegistros']);
    Route::get('/admin/venta/vista/agregar', [VentaController::class,'vistaAgregar']);
    Route::post('/admin/venta/buscar/bien/mueble', [VentaController::class,'busquedaNombreMueble']);
    Route::post('/admin/venta/buscar/bien/inmueble', [VentaController::class,'busquedaInmueble']);
    Route::post('/admin/venta/buscar/bien/maquinaria', [VentaController::class,'busquedaMaquinaria']);
    Route::get('/admin/venta/doc/{id}/{tipo}' , [VentaController::class, 'descargarDocumentoVenta']);
    Route::post('/admin/venta/nuevo', [VentaController::class,'nuevoRegistro']);
    Route::get('/admin/venta/vista/editar/{id}/{valor}', [VentaController::class,'vistaEditar']);
    Route::post('/admin/venta/editar', [VentaController::class,'editarRegistro']);
    Route::post('/admin/venta/borrar', [VentaController::class,'borrarRegistro']);

    // --- SUSTITUCION ---
    Route::get('/admin/sustitucion/index', [SustitucionController::class,'index'])->name('admin.sustitucion.index');
    Route::get('/admin/sustitucion/tabla', [SustitucionController::class,'tablaRegistros']);
    Route::get('/admin/sustitucion/vista/agregar', [SustitucionController::class,'vistaAgregar']);
    Route::post('/admin/sustitucion/buscar/bien/mueble', [SustitucionController::class,'busquedaNombreMueble']);
    Route::post('/admin/sustitucion/buscar/bien/maquinaria', [SustitucionController::class,'busquedaMaquinaria']);
    Route::post('/admin/sustitucion/nuevo', [SustitucionController::class,'nuevoRegistro']);
    Route::get('/admin/sustitucion/doc/{id}/{tipo}' , [SustitucionController::class, 'descargarDocumentoSustitucion']);
    Route::get('/admin/sustitucion/vista/editar/{id}/{valor}', [SustitucionController::class,'vistaEditar']);
    Route::post('/admin/sustitucion/editar', [SustitucionController::class,'editarRegistro']);
    Route::post('/admin/sustitucion/borrar', [SustitucionController::class,'borrarRegistro']);

    // --- REEVALUO ---
    Route::get('/admin/reevaluo/index', [ReevaluoController::class,'index'])->name('admin.reevaluo.index');
    Route::get('/admin/reevaluo/tabla', [ReevaluoController::class,'tablaRegistros']);
    Route::get('/admin/reevaluo/doc/{id}' , [ReevaluoController::class, 'descargarDocumentoReevaluo']);
    Route::get('/admin/reevaluo/vista/agregar', [ReevaluoController::class,'vistaAgregar']);
    Route::post('/admin/reevaluo/buscar/bien/inmueble', [ReevaluoController::class,'busquedaNombreInmueble']);
    Route::post('/admin/reevaluo/nuevo', [ReevaluoController::class,'nuevoRegistro']);
    Route::post('/admin/reevaluo/borrar', [ReevaluoController::class,'borrarRegistro']);
    Route::get('/admin/reevaluo/vista/editar/{id}', [ReevaluoController::class,'vistaEditar']);
    Route::post('/admin/reevaluo/editar', [ReevaluoController::class,'editarRegistro']);

    // --- DESCARGO ---
    Route::get('/admin/descargo/index', [DescargoController::class,'index'])->name('admin.descargo.index');
    Route::get('/admin/descargo/tabla', [DescargoController::class,'tablaRegistros']);
    Route::get('/admin/descargo/vista/agregar', [DescargoController::class,'vistaAgregar']);
    Route::post('/admin/descargo/buscar/bien/mueble', [DescargoController::class,'busquedaNombreMueble']);
    Route::post('/admin/descargo/buscar/bien/maquinaria', [DescargoController::class,'busquedaNombreMaquinaria']);
    Route::post('/admin/descargo/nuevo', [DescargoController::class,'nuevoRegistro']);
    Route::get('/admin/descargo/vista/editar/{id}/{valor}', [DescargoController::class,'vistaEditar']);
    Route::post('/admin/descargo/editar', [DescargoController::class,'editarRegistro']);
    Route::post('/admin/descargo/borrar', [DescargoController::class,'borrarRegistro']);




