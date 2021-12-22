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

    // --- SIN PERMISOS VISTA 403 ---
    Route::get('sin-permisos', [ControlController::class,'indexSinPermiso'])->name('no.permisos.index');

    // --- PRINCIPAL ---
    Route::get('/admin/principal/index', [PrincipalController::class,'index'])->name('admin.vista.principal');

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
    Route::post('/admin/bienes/vehiculo/borrar', [BienesVehiculoController::class, 'borrarRegistro']);

    // --- BIENES MUEBLES ---
    Route::get('/admin/bienes/muebles/index', [BienesMueblesController::class,'index'])->name('admin.bienes.muebles.index');
    Route::get('/admin/bienes/muebles/tabla', [BienesMueblesController::class,'tablaRegistros']);
    Route::get('/admin/bienes/muebles/vista-nuevo', [BienesMueblesController::class,'vistaAgregarRegistro']);
    Route::post('/admin/bienes/muebles/nuevo', [BienesMueblesController::class, 'nuevoBienMuebles']);
    Route::get('/admin/bienes/muebles/doc/{file}' , [BienesMueblesController::class, 'descargarDocumento']);
    Route::get('/admin/bienes/muebles/fac/{file}' , [BienesMueblesController::class, 'descargarFactura']);
    Route::get('/admin/bienes/muebles/vista-editar/{id}', [BienesMueblesController::class,'vistaEditarRegistro']);
    Route::post('/admin/bienes/muebles/editar', [BienesMueblesController::class, 'editarBienMuebles']);
    Route::post('/admin/bienes/muebles/borrar', [BienesMueblesController::class, 'borrarRegistro']);

    // --- BIENES INMUEBLES ---
    Route::get('/admin/bienes/inmuebles/index', [BienesInmueblesController::class,'index'])->name('admin.bienes.inmuebles.index');
    Route::get('/admin/bienes/inmuebles/tabla', [BienesInmueblesController::class,'tablaRegistros']);
    Route::get('/admin/bienes/inmuebles/vista-nuevo', [BienesInmueblesController::class,'vistaAgregarRegistro']);
    Route::post('/admin/bienes/inmuebles/nuevo', [BienesInmueblesController::class, 'nuevoBienInmuebles']);
    Route::get('/admin/bienes/inmuebles/doc/{file}' , [BienesInmueblesController::class, 'descargarDocumento']);
    Route::post('/admin/bienes/inmuebles/borrar', [BienesInmueblesController::class, 'borrarRegistro']);
    Route::get('/admin/bienes/inmuebles/vista-editar/{id}', [BienesInmueblesController::class,'vistaEditarRegistro']);
    Route::post('/admin/bienes/inmuebles/editar', [BienesInmueblesController::class, 'editarBienInmuebles']);


