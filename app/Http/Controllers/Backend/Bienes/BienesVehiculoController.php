<?php

namespace App\Http\Controllers\Backend\Bienes;

use App\Http\Controllers\Controller;
use App\Models\BienesVehiculo;
use App\Models\CodigoContable;
use App\Models\CodigoDepreciacion;
use App\Models\Departamento;
use App\Models\TipoCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class BienesVehiculoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('backend.admin.bienes.vehiculo.vistavehiculos');
    }

    public function tablaRegistros(){

        $lista = BienesVehiculo::orderBy('codigo', 'ASC')->get();

        foreach ($lista as $ll){
          $lista->fechacompra = date("d-m-Y", strtotime($ll->fechacompra));
        }

        return view('backend.admin.bienes.vehiculo.tabla.tablavehiculo', compact('lista'));
    }

    public function vistaAgregarRegistro(){

        $departamento = Departamento::orderBy('nombre')->get();
        $codcontable = CodigoContable::orderBy('nombre')->get();
        $coddepreciacion = CodigoDepreciacion::orderBy('nombre')->get();

        $codigo = BienesVehiculo::max('codigo');
        if($codigo == null){
            $codigo = 1;
        }else{
            $codigo = $codigo + 1;
        }

        return view('backend.admin.bienes.vehiculo.ingresovehiculo', compact('departamento',
            'codcontable', 'coddepreciacion', 'codigo'));
    }

    public function vistaEditarRegistro($id){
        $departamento = Departamento::orderBy('nombre')->get();
        $codcontable = CodigoContable::orderBy('nombre')->get();
        $coddepreciacion = CodigoDepreciacion::orderBy('nombre')->get();
        $tipocompra = TipoCompra::orderBy('nombre')->get();

        $info = BienesVehiculo::where('id', $id)->first();

        return view('backend.admin.bienes.vehiculo.vistaeditarvehiculo', compact('departamento',
            'codcontable', 'coddepreciacion', 'info', 'tipocompra'));
    }

    public function nuevoBienVehiculo(Request $request){

        if(BienesVehiculo::where('codigo', $request->codigo)->first()){
           // hay datos
        }else{
            // no hay datos
        }

        if($request->hasFile('documento')){

            $cadena = Str::random(15);
            $tiempo = microtime();
            $union = $cadena.$tiempo;
            $nombre = str_replace(' ', '_', $union);

            $extension = '.'.$request->documento->getClientOriginalExtension();
            $nombreDoc = $nombre.strtolower($extension);
            $avatar = $request->file('documento');
            $upload = Storage::disk('archivos')->put($nombreDoc, \File::get($avatar));

            if($upload){

                $ve = new BienesVehiculo();
                $ve->id_tipocompra = $request->tipocompra;
                $ve->id_coddepreci = $request->coddepreciacion;
                $ve->id_codcontable = $request->codcontable;
                $ve->id_departamento = $request->departamento;

                $ve->descripcion = $request->descripcion;
                $ve->valor = $request->valor;
                $ve->placa = $request->placa;
                $ve->motorista = $request->motorista;
                $ve->vidautil = $request->vidautil;
                $ve->fechacompra = $request->fechacompra;
                $ve->anio = $request->anio;
                $ve->fechavectar = $request->vectarjeta;
                $ve->encargado = $request->encargado;
                $ve->valresidual = $request->valorresidual;
                $ve->observaciones = $request->observaciones;
                $ve->codigo = $request->codigo;
                if($ve->save()) {
                    $codigo = BienesVehiculo::max('codigo');
                    $codigo = $codigo + 1;
                    return ['success' => 2, 'codigo' => $codigo];
                }else{
                    return ['success' => 3];
                }
            }else{
                return ['success' => 3];
            }
        }else{
            // solo guardar datos
            $ve = new BienesVehiculo();
            $ve->id_tipocompra = $request->tipocompra;
            $ve->id_coddepreci = $request->coddepreciacion;
            $ve->id_codcontable = $request->codcontable;
            $ve->id_departamento = $request->departamento;

            $ve->descripcion = $request->descripcion;
            $ve->valor = $request->valor;
            $ve->placa = $request->placa;
            $ve->motorista = $request->motorista;
            $ve->vidautil = $request->vidautil;
            $ve->fechacompra = $request->fechacompra;
            $ve->anio = $request->anio;
            $ve->fechavectar = $request->vectarjeta;
            $ve->encargado = $request->encargado;
            $ve->valresidual = $request->valorresidual;
            $ve->observaciones = $request->observaciones;
            $ve->codigo = $request->codigo;

            if($ve->save()) {
                $codigo = BienesVehiculo::max('codigo');
                $codigo = $codigo + 1;
                return ['success' => 2, 'codigo' => $codigo];
            }else{
                return ['success' => 3];
            }
        }
    }

    public function editarBienVehiculo(Request $request){

        if($data = BienesVehiculo::where('id', $request->id)->first()){

            if(BienesVehiculo::where('id', '!=', $request->id)
                ->where('codigo', $request->codigo)
                ->first()){
                return ['success' => 1];
            }

            $documentoOld = $data->documento;

            if($request->hasFile('documento')){

                $cadena = Str::random(15);
                $tiempo = microtime();
                $union = $cadena.$tiempo;
                $nombre = str_replace(' ', '_', $union);

                $extension = '.'.$request->documento->getClientOriginalExtension();
                $nombreDoc = $nombre.strtolower($extension);
                $avatar = $request->file('documento');
                $upload = Storage::disk('archivos')->put($nombreDoc, \File::get($avatar));

                if($upload){

                    BienesVehiculo::where('id', $request->id)->update([
                        'id_tipocompra' => $request->tipocompra,
                        'id_coddepreci' => $request->coddepreciacion,
                        'id_codcontable' => $request->codcontable,
                        'id_departamento' => $request->departamento,
                        'descripcion' => $request->descripcion,
                        'valor' => $request->valor,
                        'placa' => $request->placa,
                        'motorista' => $request->motorista,
                        'vidautil' => $request->vidautil,
                        'fechacompra' => $request->fechacompra,
                        'anio' => $request->anio,
                        'fechavectar' => $request->vectarjeta,
                        'encargado' => $request->encargado,
                        'valresidual' => $request->valorresidual,
                        'observaciones' => $request->observaciones,
                        'documento' => $nombreDoc
                    ]);

                    // borrar archivo anterior
                    if(Storage::disk('archivos')->exists($documentoOld)){
                        Storage::disk('archivos')->delete($documentoOld);
                    }

                    return ['success' => 2];
                }else{
                    return ['success' => 3];
                }
            }else{
                // solo guardar datos

                BienesVehiculo::where('id', $request->id)->update([
                    'id_tipocompra' => $request->tipocompra,
                    'id_coddepreci' => $request->coddepreciacion,
                    'id_codcontable' => $request->codcontable,
                    'id_departamento' => $request->departamento,
                    'descripcion' => $request->descripcion,
                    'valor' => $request->valor,
                    'placa' => $request->placa,
                    'motorista' => $request->motorista,
                    'vidautil' => $request->vidautil,
                    'fechacompra' => $request->fechacompra,
                    'anio' => $request->anio,
                    'fechavectar' => $request->vectarjeta,
                    'encargado' => $request->encargado,
                    'valresidual' => $request->valorresidual,
                    'observaciones' => $request->observaciones,
                ]);

                return ['success' => 2];
            }
        }else{
            return ['success' => 3];
        }
    }

    public function descargarDocumento($id){

        $url = BienesVehiculo::where('id', $id)->pluck('documento')->first();

        $pathToFile = "storage/archivos/".$url;

        $extension = pathinfo(($pathToFile), PATHINFO_EXTENSION);

        $nombre = "Documento." . $extension;

        return response()->download($pathToFile, $nombre);
    }


}
