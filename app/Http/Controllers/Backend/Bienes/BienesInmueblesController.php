<?php

namespace App\Http\Controllers\Backend\Bienes;

use App\Http\Controllers\Controller;
use App\Models\BienesInmuebles;
use App\Models\Estados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BienesInmueblesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('backend.admin.bienes.inmuebles.vistabienesinmuebles');
    }

    public function tablaRegistros(){

        $lista = BienesInmuebles::orderBy('id', 'ASC')->get();

        foreach ($lista as $ll){
            $lista->fechacompra = date("d-m-Y", strtotime($ll->fechacompra));
        }

        return view('backend.admin.bienes.inmuebles.tabla.tablabienesinmuebles', compact('lista'));
    }

    public function vistaAgregarRegistro(){
        $codigo = BienesInmuebles::max('codigo');
        if($codigo == null){
            $codigo = 1;
        }else{
            $codigo = $codigo + 1;
        }


        $estados = Estados::orderBy('nombre')->get();

        return view('backend.admin.bienes.inmuebles.ingresobienesinmuebles', compact('codigo',
            'estados'));
    }

    public function nuevoBienInmuebles(Request $request){

        if(BienesInmuebles::where('codigo', $request->codigo)->first()){
            return ['success' => 1];
        }

        if($request->hasFile('documento')){

            $cadena = Str::random(15);
            $tiempo = microtime();
            $union = $cadena.$tiempo;
            $nombre = str_replace(' ', '_', $union);

            $extension = '.'.$request->documento->getClientOriginalExtension();
            $nomDocumento = $nombre.strtolower($extension);
            $avatar = $request->file('documento');
            Storage::disk('archivos')->put($nomDocumento, \File::get($avatar));

            $ve = new BienesInmuebles();
            $ve->codigo = $request->codigo;
            $ve->descripcion = $request->descripcion;
            $ve->valor = $request->valor;
            $ve->ubicacion = $request->ubicacion;
            $ve->documento = $nomDocumento;
            $ve->inscrito = $request->inscrito;
            $ve->valorregistrado = $request->valorregistrado;
            $ve->observaciones = $request->observaciones;
            $ve->fechacompra = $request->fechacompra;
            $ve->contiene = $request->contiene;
            $ve->id_estados = $request->estado;
            $ve->edificaciones = $request->edificaciones;
            $ve->fechapermuta = $request->fechapermuta;

            if($ve->save()) {

                $codigo = BienesInmuebles::max('codigo');
                $codigo = $codigo + 1;
                return ['success' => 2, 'codigo' => $codigo];
            }else{
                return ['success' => 3];
            }

        }else{
            $ve = new BienesInmuebles();
            $ve->codigo = $request->codigo;
            $ve->descripcion = $request->descripcion;
            $ve->valor = $request->valor;
            $ve->ubicacion = $request->ubicacion;
            $ve->inscrito = $request->inscrito;
            $ve->valorregistrado = $request->valorregistrado;
            $ve->observaciones = $request->observaciones;
            $ve->fechacompra = $request->fechacompra;
            $ve->contiene = $request->contiene;
            $ve->id_estados = $request->estado;
            $ve->edificaciones = $request->edificaciones;
            $ve->fechapermuta = $request->fechapermuta;

            if($ve->save()) {
                $codigo = BienesInmuebles::max('codigo');
                $codigo = $codigo + 1;
                return ['success' => 2, 'codigo' => $codigo];
            }else{
                return ['success' => 3];
            }
        }
    }

    public function descargarDocumento($id){

        $url = BienesInmuebles::where('id', $id)->pluck('documento')->first();

        $pathToFile = "storage/archivos/".$url;

        $extension = pathinfo(($pathToFile), PATHINFO_EXTENSION);

        $nombre = "Documento." . $extension;

        return response()->download($pathToFile, $nombre);
    }

    public function vistaEditarRegistro($id){

        $info = BienesInmuebles::where('id', $id)->first();
        $estados = Estados::orderBy('nombre')->get();

        $mensaje = "";
        if($info->documento != null){
            $mensaje = "Ya hay un documento";
        }

        return view('backend.admin.bienes.inmuebles.vistaeditarbienesinmuebles', compact('info', 'estados', 'mensaje'));
    }

    public function editarBienInmuebles(Request $request){

        if(BienesInmuebles::where('id', '!=', $request->id)
            ->where('codigo', $request->codigo)->first()){
            return ['success' => 1];
        }

        if($infoBien = BienesInmuebles::where('id', $request->id)->first()){

            $documentoOld = $infoBien->documento;

            if($request->hasFile('documento')){
                $cadena = Str::random(15);
                $tiempo = microtime();
                $union = $cadena.$tiempo;
                $nombre = str_replace(' ', '_', $union);

                $extension = '.'.$request->documento->getClientOriginalExtension();
                $nomDocumento = $nombre.strtolower($extension);
                $avatar = $request->file('documento');
                Storage::disk('archivos')->put($nomDocumento, \File::get($avatar));

                BienesInmuebles::where('id', $request->id)->update([
                    'codigo' => $request->codigo,
                    'descripcion' => $request->descripcion,
                    'valor' => $request->valor,
                    'ubicacion' => $request->ubicacion,
                    'documento' => $nomDocumento,
                    'inscrito' => $request->inscrito,
                    'valorregistrado' => $request->valorregistrado,
                    'observaciones' => $request->observaciones,
                    'fechacompra' => $request->fechacompra,
                    'contiene' => $request->contiene,
                    'id_estados' => $request->estado,
                    'edificaciones' => $request->edificaciones,
                    'fechapermuta' => $request->fechapermuta,
                ]);

                if(Storage::disk('archivos')->exists($documentoOld)){
                    Storage::disk('archivos')->delete($documentoOld);
                }

                return ['success' => 2];
            }else{

                BienesInmuebles::where('id', $request->id)->update([
                    'codigo' => $request->codigo,
                    'descripcion' => $request->descripcion,
                    'valor' => $request->valor,
                    'ubicacion' => $request->ubicacion,
                    'inscrito' => $request->inscrito,
                    'valorregistrado' => $request->valorregistrado,
                    'observaciones' => $request->observaciones,
                    'fechacompra' => $request->fechacompra,
                    'contiene' => $request->contiene,
                    'id_estados' => $request->estado,
                    'edificaciones' => $request->edificaciones,
                    'fechapermuta' => $request->fechapermuta,
                ]);

                return ['success' => 2];
            }

        }else{
            return ['success' => 3];
        }
    }
}
