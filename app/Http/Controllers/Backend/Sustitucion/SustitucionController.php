<?php

namespace App\Http\Controllers\Backend\Sustitucion;

use App\Http\Controllers\Controller;
use App\Models\BienesMuebles;
use App\Models\BienesVehiculo;
use App\Models\SustitucionMaquinaria;
use App\Models\SustitucionMueble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SustitucionController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('backend.admin.principal.sustitucion.vistasustitucion');
    }

    public function tablaRegistros(){
        $listaMueble = SustitucionMueble::all();
        $listaMaquina = SustitucionMaquinaria::all();

        $dataArray = array();

        foreach ($listaMueble as $ll) {

            $fecha = "";
            if($ll->fecha != null){
                $fecha = date("d-m-Y", strtotime($ll->fecha));
            }

            $datos = BienesMuebles::where('id', $ll->id_bienmueble)->first();

            $dataArray[] = [
                'id' => $ll->id,
                'codigo' => $datos->codigo,
                'descripcion' => $datos->descripcion,

                'valorsustituido' => $ll->piezasustituida,
                'valorajustado' => $ll->valorajustado,
                'valornuevo' => $ll->piezanueva,
                'vida' => $ll->vidautil,

                'tipo' => 'Bien Mueble',
                'doc' => 1, // para saber que documento descargar
                'documento' => $ll->documento,
                'fecha' => $fecha,
            ];
        }

        foreach ($listaMaquina as $llMa) {

            $fecha = "";
            if($llMa->fecha != null) {
                $fecha = date("d-m-Y", strtotime($llMa->fecha));
            }

            $datos = BienesVehiculo::where('id', $llMa->id_bienvehiculo)->first();

            $dataArray[] = [
                'id' => $llMa->id,
                'codigo' => $datos->codigo,
                'descripcion' => $datos->descripcion,

                'valorsustituido' => $llMa->piezasustituida,
                'valorajustado' => $llMa->valorajustado,
                'valornuevo' => $llMa->piezanueva,
                'vida' => $llMa->vidautil,

                'tipo' => 'Vehículos y Maquinaria',
                'doc' => 2, // para saber que documento descargar
                'documento' => $llMa->documento,
                'fecha' => $fecha,
            ];
        }

        usort($dataArray, array( $this, 'sortDate' ));

        return view('backend.admin.principal.sustitucion.tabla.tablasustitucion', compact('dataArray'));
    }

    function vistaAgregar(){
        return view('backend.admin.principal.sustitucion.vistaagregarsustitucion');
    }

    public function busquedaNombreMueble(Request $request){

        if($request->get('query')){
            $query = $request->get('query');
            $data = BienesMuebles::where('descripcion', 'LIKE', "%{$query}%")->take(25)->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            $tiene = true;
            foreach($data as $row){

                if(!empty($row)){
                    $tiene = false;
                    $output .= '
                 <li onclick="modificarValor('.$row->id.','.$row->id_departamento.')"><a href="#">'.$row->descripcion.'</a></li>
                ';
                }
            }
            $output .= '</ul>';
            if($tiene){
                $output = null;
            }
            echo $output;
        }
    }

    public function busquedaMaquinaria(Request $request){

        if($request->get('query')){
            $query = $request->get('query');
            $data = BienesVehiculo::where('descripcion', 'LIKE', "%{$query}%")->take(25)->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            $tiene = true;
            foreach($data as $row){

                if(!empty($row)){
                    $tiene = false;
                    $output .= '
                 <li onclick="modificarValor('.$row->id.','.$row->id_departamento.')"><a href="#">'.$row->descripcion.'</a></li>
                ';
                }
            }
            $output .= '</ul>';
            if($tiene){
                $output = null;
            }
            echo $output;
        }
    }

    public function nuevoRegistro(Request $request){

        if($request->tipo == 1){ // muebles

            if($info = BienesMuebles::where('id', $request->id)->first()){

                if($request->hasFile('documento')){
                    $cadena = Str::random(15);
                    $tiempo = microtime();
                    $union = $cadena.$tiempo;
                    $nombre = str_replace(' ', '_', $union);

                    $extension = '.'.$request->documento->getClientOriginalExtension();
                    $nomDocumento = $nombre.strtolower($extension);
                    $avatar = $request->file('documento');
                    $estado = Storage::disk('archivos')->put($nomDocumento, \File::get($avatar));

                    if($estado){
                        $co = new SustitucionMueble();
                        $co->id_bienmueble = $info->id;

                        $co->piezasustituida = $request->piezasustituida;
                        $co->valorajustado = $request->valorajustado;
                        $co->piezanueva = $request->piezanueva;
                        $co->vidautil = $request->vidautil;
                        $co->observaciones = $request->observaciones;
                        $co->fecha = $request->fecha;
                        $co->documento = $nomDocumento;

                        if($co->save()){return ['success' => 2];}else{return ['success' => 3];}
                    }else{
                        return ['success' => 3];
                    }

                }else{
                    $co = new SustitucionMueble();
                    $co->id_bienmueble = $info->id;

                    $co->piezasustituida = $request->piezasustituida;
                    $co->valorajustado = $request->valorajustado;
                    $co->piezanueva = $request->piezanueva;
                    $co->vidautil = $request->vidautil;
                    $co->observaciones = $request->observaciones;
                    $co->fecha = $request->fecha;

                    if($co->save()){return ['success' => 2];}else{return ['success' => 3];}
                }

            }else{
                return ['success' => 1];
            }
        }

       else if($request->tipo == 2){ // maquinaria

            if($info = BienesVehiculo::where('id', $request->id)->first()){

                if($request->hasFile('documento')){
                    $cadena = Str::random(15);
                    $tiempo = microtime();
                    $union = $cadena.$tiempo;
                    $nombre = str_replace(' ', '_', $union);

                    $extension = '.'.$request->documento->getClientOriginalExtension();
                    $nomDocumento = $nombre.strtolower($extension);
                    $avatar = $request->file('documento');
                    $estado = Storage::disk('archivos')->put($nomDocumento, \File::get($avatar));

                    if($estado){
                        $co = new SustitucionMaquinaria();
                        $co->id_bienvehiculo = $info->id;

                        $co->piezasustituida = $request->piezasustituida;
                        $co->valorajustado = $request->valorajustado;
                        $co->piezanueva = $request->piezanueva;
                        $co->vidautil = $request->vidautil;
                        $co->observaciones = $request->observaciones;
                        $co->fecha = $request->fecha;
                        $co->documento = $nomDocumento;

                        if($co->save()){return ['success' => 2];}else{return ['success' => 3];}
                    }else{
                        return ['success' => 3];
                    }

                }else{
                    $co = new SustitucionMaquinaria();
                    $co->id_bienvehiculo = $info->id;

                    $co->piezasustituida = $request->piezasustituida;
                    $co->valorajustado = $request->valorajustado;
                    $co->piezanueva = $request->piezanueva;
                    $co->vidautil = $request->vidautil;
                    $co->observaciones = $request->observaciones;
                    $co->fecha = $request->fecha;

                    if($co->save()){return ['success' => 2];}else{return ['success' => 3];}
                }

            }else{
                return ['success' => 1];
            }

        }else{
            return ['success' => 3];
        }
    }

    public function descargarDocumentoSustitucion($id, $tipo){

        if($tipo == 1){
            $url = SustitucionMueble::where('id', $id)->pluck('documento')->first();
        }
        else if($tipo == 2){
            $url = SustitucionMaquinaria::where('id', $id)->pluck('documento')->first();
        }else{
            $url = SustitucionMueble::where('id', $id)->pluck('documento')->first();
        }

        $pathToFile = "storage/archivos/".$url;

        $extension = pathinfo(($pathToFile), PATHINFO_EXTENSION);

        $nombre = "Documento." . $extension;

        return response()->download($pathToFile, $nombre);
    }

    function vistaEditar($id, $valor){

        if($valor == 1){
            $info = SustitucionMueble::where('id', $id)->first();
            $data = BienesMuebles::where('id', $info->id_bienmueble)->first();
            $nombre = $data->descripcion;
            $idbien = $data->id;
            $tipo = "Bien Mueble";
        }
        else if($valor == 2){
            $info = SustitucionMaquinaria::where('id', $id)->first();
            $data = BienesVehiculo::where('id', $info->id_bienvehiculo)->first();
            $nombre = $data->descripcion;
            $idbien = $data->id;
            $tipo = "Bien Vehículos y Maquinaria";
        }
        else{
            $info = SustitucionMueble::where('id', $id)->first();
            $data = BienesMuebles::where('id', $info->id_bienmueble)->first();
            $nombre = $data->descripcion;
            $idbien = $data->id;
            $tipo = "Bien Mueble";
        }

        return view('backend.admin.principal.sustitucion.vistaeditarsustitucion', compact('info', 'tipo', 'nombre', 'id', 'idbien', 'valor'));
    }


    public function editarRegistro(Request $request){

        if($request->valor == 1){ // mueble

            // buscar si existe el id bien
            if($info = BienesMuebles::where('id', $request->idbien)->first()){
                if($data = SustitucionMueble::where('id', $request->id)->first()){

                    if($request->hasFile('documento')){

                        $documentoOld = $data->documento;

                        $cadena = Str::random(15);
                        $tiempo = microtime();
                        $union = $cadena.$tiempo;
                        $nombre = str_replace(' ', '_', $union);

                        $extension = '.'.$request->documento->getClientOriginalExtension();
                        $nomDocumento = $nombre.strtolower($extension);
                        $avatar = $request->file('documento');
                        $estado = Storage::disk('archivos')->put($nomDocumento, \File::get($avatar));

                        if($estado){

                            SustitucionMueble::where('id', $request->id)->update([
                                'id_bienmueble' => $info->id,
                                'piezasustituida' => $request->piezasustituida,
                                'valorajustado' =>$request->valorajustado,
                                'piezanueva' => $request->piezanueva,
                                'vidautil' => $request->vidautil,
                                'observaciones' => $request->observaciones,
                                'fecha' => $request->fecha,
                                'documento' => $nomDocumento
                            ]);

                            if(Storage::disk('archivos')->exists($documentoOld)){
                                Storage::disk('archivos')->delete($documentoOld);
                            }

                            return ['success' => 2];
                        }else{
                            return ['success' => 3];
                        }

                    }else{

                        SustitucionMueble::where('id', $request->id)->update([
                            'id_bienmueble' => $info->id,
                            'piezasustituida' => $request->piezasustituida,
                            'valorajustado' =>$request->valorajustado,
                            'piezanueva' => $request->piezanueva,
                            'vidautil' => $request->vidautil,
                            'observaciones' => $request->observaciones,
                            'fecha' => $request->fecha,
                        ]);

                        return ['success' => 2];
                    }

                }else{
                    return ['success' => 3];
                }
            }else{
                return ['success' => 1];
            }
        }

        else if($request->valor == 2){ // vehiculo y maquinaria

            if($info = BienesVehiculo::where('id', $request->idbien)->first()){
                if($data = SustitucionMaquinaria::where('id', $request->id)->first()){

                    if($request->hasFile('documento')){

                        $documentoOld = $data->documento;

                        $cadena = Str::random(15);
                        $tiempo = microtime();
                        $union = $cadena.$tiempo;
                        $nombre = str_replace(' ', '_', $union);

                        $extension = '.'.$request->documento->getClientOriginalExtension();
                        $nomDocumento = $nombre.strtolower($extension);
                        $avatar = $request->file('documento');
                        $estado = Storage::disk('archivos')->put($nomDocumento, \File::get($avatar));

                        if($estado){

                            SustitucionMaquinaria::where('id', $request->id)->update([
                                'id_bienvehiculo' => $info->id,
                                'piezasustituida' => $request->piezasustituida,
                                'valorajustado' =>$request->valorajustado,
                                'piezanueva' => $request->piezanueva,
                                'vidautil' => $request->vidautil,
                                'observaciones' => $request->observaciones,
                                'fecha' => $request->fecha,
                                'documento' => $nomDocumento
                            ]);

                            if(Storage::disk('archivos')->exists($documentoOld)){
                                Storage::disk('archivos')->delete($documentoOld);
                            }

                            return ['success' => 2];
                        }else{
                            return ['success' => 3];
                        }

                    }else{

                        SustitucionMaquinaria::where('id', $request->id)->update([
                            'id_bienvehiculo' => $info->id,
                            'piezasustituida' => $request->piezasustituida,
                            'valorajustado' =>$request->valorajustado,
                            'piezanueva' => $request->piezanueva,
                            'vidautil' => $request->vidautil,
                            'observaciones' => $request->observaciones,
                            'fecha' => $request->fecha,
                        ]);

                        return ['success' => 2];
                    }

                }else{
                    return ['success' => 3];
                }
            }else{
                return ['success' => 1];
            }

        }
        else{
            // defecto bien mueble
            if($info = BienesVehiculo::where('id', $request->idbien)->first()){
                if($data = SustitucionMueble::where('id', $request->id)->first()){

                    if($request->hasFile('documento')){

                        $documentoOld = $data->documento;

                        $cadena = Str::random(15);
                        $tiempo = microtime();
                        $union = $cadena.$tiempo;
                        $nombre = str_replace(' ', '_', $union);

                        $extension = '.'.$request->documento->getClientOriginalExtension();
                        $nomDocumento = $nombre.strtolower($extension);
                        $avatar = $request->file('documento');
                        $estado = Storage::disk('archivos')->put($nomDocumento, \File::get($avatar));

                        if($estado){

                            SustitucionMueble::where('id', $request->id)->update([
                                'id_bienmueble' => $info->id,
                                'piezasustituida' => $request->piezasustituida,
                                'valorajustado' =>$request->valorajustado,
                                'piezanueva' => $request->piezanueva,
                                'vidautil' => $request->vidautil,
                                'observaciones' => $request->observaciones,
                                'fecha' => $request->fecha,
                                'documento' => $nomDocumento
                            ]);

                            if(Storage::disk('archivos')->exists($documentoOld)){
                                Storage::disk('archivos')->delete($documentoOld);
                            }

                            return ['success' => 2];
                        }else{
                            return ['success' => 3];
                        }

                    }else{

                        SustitucionMueble::where('id', $request->id)->update([
                            'id_bienmueble' => $info->id,
                            'piezasustituida' => $request->piezasustituida,
                            'valorajustado' =>$request->valorajustado,
                            'piezanueva' => $request->piezanueva,
                            'vidautil' => $request->vidautil,
                            'observaciones' => $request->observaciones,
                            'fecha' => $request->fecha,
                        ]);

                        return ['success' => 2];
                    }

                }else{
                    return ['success' => 3];
                }
            }else{
                return ['success' => 1];
            }
        }
    }


    public function borrarRegistro(Request $request){

        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if($request->valor == 1){
            if($data = SustitucionMueble::where('id', $request->id)->first()){

                $documentoOld = $data->documento;

                SustitucionMueble::where('id', $request->id)->delete();

                // borrar documento
                if(Storage::disk('archivos')->exists($documentoOld)){
                    Storage::disk('archivos')->delete($documentoOld);
                }

                return ['success' => 1];
            }else{
                return ['success' => 2];
            }
        }
        else if($request->valor == 2){
            if($data = SustitucionMaquinaria::where('id', $request->id)->first()){

                $documentoOld = $data->documento;

                SustitucionMaquinaria::where('id', $request->id)->delete();

                // borrar documento
                if(Storage::disk('archivos')->exists($documentoOld)){
                    Storage::disk('archivos')->delete($documentoOld);
                }

                return ['success' => 1];
            }else{
                return ['success' => 2];
            }
        }else{
            if($data = SustitucionMueble::where('id', $request->id)->first()){

                $documentoOld = $data->documento;

                SustitucionMueble::where('id', $request->id)->delete();

                // borrar documento
                if(Storage::disk('archivos')->exists($documentoOld)){
                    Storage::disk('archivos')->delete($documentoOld);
                }

                return ['success' => 1];
            }else{
                return ['success' => 2];
            }
        }
    }

    public function sortDate($a, $b){
        //if($a['fecha'] != null && $b['fecha'] != null) {
        if (strtotime($a['fecha']) == strtotime($b['fecha'])) return 0;

        // con el simbolo > vamos a ordenar que las Fechas ultimas sean la primera posicion
        // con el simbolo < vamos a ordenar que las Fechas primeras este en la primera posicion
        return (strtotime($a['fecha']) > strtotime($b['fecha'])) ? -1 : 1;
        //}
    }
}
