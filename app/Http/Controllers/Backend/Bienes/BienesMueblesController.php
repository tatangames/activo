<?php

namespace App\Http\Controllers\Backend\Bienes;

use App\Http\Controllers\Controller;
use App\Models\BienesMuebles;
use App\Models\CodigoContable;
use App\Models\CodigoDepreciacion;
use App\Models\Departamento;
use App\Models\Descriptor;
use App\Models\TipoCompra;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BienesMueblesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('backend.admin.bienes.muebles.vistabienesmuebles');
    }

    public function tablaRegistros(){

        $lista = BienesMuebles::orderBy('id', 'ASC')->get();

        foreach ($lista as $ll){
            $lista->fechacompra = date("d-m-Y", strtotime($ll->fechacompra));

            $infoDepartamento = Departamento::where('id', $ll->id_departamento)->first();
            $infoDescriptor = Descriptor::where('id', $ll->id_descriptor)->first();

            $codigo = $infoDepartamento->codigo . '-' . $infoDescriptor->codigodes . '-' . $ll->correlativo;

            $ll->codigo = $codigo;
        }

        return view('backend.admin.bienes.muebles.tabla.tablabienesmuebles', compact('lista'));
    }

    public function vistaAgregarRegistro(){

        $departamento = Departamento::orderBy('nombre')->get();
        $codcontable = CodigoContable::orderBy('nombre')->get();
        $coddepreciacion = CodigoDepreciacion::orderBy('nombre')->get();
        $coddescriptor = Descriptor::orderBy('descripcion')->get();

        return view('backend.admin.bienes.muebles.ingresobienesmuebles', compact('departamento',
            'codcontable', 'coddepreciacion', 'coddescriptor'));
    }

    public function nuevoBienMuebles(Request $request){

        if($request->hasFile('documento') || $request->hasFile('factura')){

            $nomDocumento = null;
            $nomFactura = null;

            if($request->hasFile('documento')){
                $cadena = Str::random(15);
                $tiempo = microtime();
                $union = $cadena.$tiempo;
                $nombre = str_replace(' ', '_', $union);

                $extension = '.'.$request->documento->getClientOriginalExtension();
                $nomDocumento = $nombre.strtolower($extension);
                $avatar = $request->file('documento');
                Storage::disk('archivos')->put($nomDocumento, \File::get($avatar));
            }

            if($request->hasFile('factura')){
                $cadena2 = Str::random(15);
                $tiempo2 = microtime();
                $union2 = $cadena2.$tiempo2;
                $nombre2 = str_replace(' ', '_', $union2);

                $extension2 = '.'.$request->factura->getClientOriginalExtension();
                $nomFactura = $nombre2.strtolower($extension2);
                $avatar2 = $request->file('factura');
                Storage::disk('archivos')->put($nomFactura, \File::get($avatar2));
            }

            // correlativo
            $dato = BienesMuebles::where('id_descriptor', $request->coddedescriptor)
                ->where('id_departamento', $request->departamento)
                ->max('correlativo');

            $correlativo = $dato + 1;

            $ve = new BienesMuebles();
            $ve->id_departamento = $request->departamento;
            $ve->id_codcontable = $request->codcontable;
            $ve->id_coddepreci = $request->coddepreciacion;
            $ve->id_descriptor = $request->coddedescriptor;
            $ve->id_tipocompra = $request->tipocompra;
            $ve->codigo = "";
            $ve->descripcion = $request->descripcion;
            $ve->valor = $request->valor;
            $ve->fechacompra = $request->fechacompra;
            $ve->documento = $nomDocumento;
            $ve->factura = $nomFactura;
            $ve->observaciones = $request->observaciones;
            $ve->vidautil = $request->vidautil;
            $ve->valresidual = $request->valorresidual;
            $ve->correlativo = $correlativo;

            if($ve->save()) {
                return ['success' => 1];
            }else{
                return ['success' => 2];
            }

        }else{
            // correlativo
            $dato = BienesMuebles::where('id_descriptor', $request->coddedescriptor)->max('correlativo');
            $correlativo = $dato + 1;

            // solo guardar datos
            $ve = new BienesMuebles();
            $ve->id_departamento = $request->departamento;
            $ve->id_codcontable = $request->codcontable;
            $ve->id_coddepreci = $request->coddepreciacion;
            $ve->id_descriptor = $request->coddedescriptor;
            $ve->id_tipocompra = $request->tipocompra;
            $ve->codigo = "";
            $ve->descripcion = $request->descripcion;
            $ve->valor = $request->valor;
            $ve->fechacompra = $request->fechacompra;
            $ve->observaciones = $request->observaciones;
            $ve->vidautil = $request->vidautil;
            $ve->valresidual = $request->valorresidual;
            $ve->correlativo = $correlativo;

            if($ve->save()) {
                return ['success' => 1];
            }else{
                return ['success' => 2];
            }
        }
    }

    public function descargarDocumento($id){

        $url = BienesMuebles::where('id', $id)->pluck('documento')->first();

        $pathToFile = "storage/archivos/".$url;

        $extension = pathinfo(($pathToFile), PATHINFO_EXTENSION);

        $nombre = "Documento." . $extension;

        return response()->download($pathToFile, $nombre);
    }

    public function descargarFactura($id){

        $url = BienesMuebles::where('id', $id)->pluck('factura')->first();

        $pathToFile = "storage/archivos/".$url;

        $extension = pathinfo(($pathToFile), PATHINFO_EXTENSION);

        $nombre = "Factura." . $extension;

        return response()->download($pathToFile, $nombre);
    }

    public function borrarRegistro(Request $request){

        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if($data = BienesMuebles::where('id', $request->id)->first()){

            $documentoOld = $data->documento;
            $facturaOld = $data->factura;
            $idCorrelativo = $data->id_descriptor;

            BienesMuebles::where('id', $request->id)->delete();

            // actualizar correlativo
            $correlativo = 0;
            $info = BienesMuebles::where('id_descriptor', $idCorrelativo)->get();
            foreach ($info as $ll){
                $correlativo++;

                BienesMuebles::where('id', $ll->id)->update([
                    'correlativo' => $correlativo,
                ]);
            }

            // borrar documento
            if(Storage::disk('archivos')->exists($documentoOld)){
                Storage::disk('archivos')->delete($documentoOld);
            }

            // borrar factura
            if(Storage::disk('archivos')->exists($facturaOld)){
                Storage::disk('archivos')->delete($facturaOld);
            }

            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }

    public function vistaEditarRegistro($id){
        $departamento = Departamento::orderBy('nombre')->get();
        $codcontable = CodigoContable::orderBy('nombre')->get();
        $coddepreciacion = CodigoDepreciacion::orderBy('nombre')->get();
        $coddescriptor = Descriptor::orderBy('descripcion')->get();
        $tipocompra = TipoCompra::orderBy('id', 'ASC')->get();

        $info = BienesMuebles::where('id', $id)->first();

        return view('backend.admin.bienes.muebles.vistaeditarbienesmuebles', compact('departamento',
            'codcontable', 'coddepreciacion', 'info', 'coddescriptor', 'tipocompra'));
    }

    public function editarBienMuebles(Request $request){

        if($infoBien = BienesMuebles::where('id', $request->id)->first()){

            $documentoOld = $infoBien->documento;
            $facturaOld = $infoBien->factura;
            $iddepa = $infoBien->id_departamento;
            $iddescri = $infoBien->id_descriptor;

            if($request->hasFile('documento')){
                $cadena = Str::random(15);
                $tiempo = microtime();
                $union = $cadena.$tiempo;
                $nombre = str_replace(' ', '_', $union);

                $extension = '.'.$request->documento->getClientOriginalExtension();
                $nomDocumento = $nombre.strtolower($extension);
                $avatar = $request->file('documento');
                Storage::disk('archivos')->put($nomDocumento, \File::get($avatar));

                BienesMuebles::where('id', $request->id)->update([
                    'documento' => $nomDocumento,
                ]);

                if(Storage::disk('archivos')->exists($documentoOld)){
                    Storage::disk('archivos')->delete($documentoOld);
                }
            }

            if($request->hasFile('factura')){
                $cadena2 = Str::random(15);
                $tiempo2 = microtime();
                $union2 = $cadena2.$tiempo2;
                $nombre2 = str_replace(' ', '_', $union2);

                $extension2 = '.'.$request->factura->getClientOriginalExtension();
                $nomFactura = $nombre2.strtolower($extension2);
                $avatar2 = $request->file('factura');
                Storage::disk('archivos')->put($nomFactura, \File::get($avatar2));

                BienesMuebles::where('id', $request->id)->update([
                    'factura' => $nomFactura,
                ]);

                if(Storage::disk('archivos')->exists($facturaOld)){
                    Storage::disk('archivos')->delete($facturaOld);
                }
            }

            BienesMuebles::where('id', $request->id)->update([
                'id_tipocompra' => $request->tipocompra,
                'id_coddepreci' => $request->coddepreciacion,
                'id_codcontable' => $request->codcontable,
                'id_descriptor' => $request->coddescriptor,
                'id_departamento' => $request->departamento,
                'descripcion' => $request->descripcion,
                'valor' => $request->valor,
                'vidautil' => $request->vidautil,
                'fechacompra' => $request->fechacompra,
                'valresidual' => $request->valorresidual,
                'observaciones' => $request->observaciones,
            ]);

            if($iddepa == $request->departamento &&
                $iddescri == $request->coddescriptor){
                // no se actualizara correlativo

            }else{
                $correlaAntiguo = 0;
                $correlaNuevo = 0;

                // actualizar anterior id departamento y id descriptor
                // antiguo
                $infoAntiguo = BienesMuebles::where('id_descriptor', $iddescri)
                    ->where('id_departamento', $iddepa)
                    ->get();

                foreach ($infoAntiguo as $ll){
                    $correlaAntiguo++;

                    BienesMuebles::where('id', $ll->id)->update([
                        'correlativo' => $correlaAntiguo,
                    ]);
                }

                // actualizar correlativo nuevo
                $infoNuevo = BienesMuebles::where('id_descriptor', $request->coddescriptor)
                    ->where('id_departamento', $request->departamento)
                    ->get();

                foreach ($infoNuevo as $ll){
                    $correlaNuevo++;

                    BienesMuebles::where('id', $ll->id)->update([
                        'correlativo' => $correlaNuevo,
                    ]);
                }
            }

            return ['success' => 1];
        }else{
            return ['success' => 2];
        }

    }

}
