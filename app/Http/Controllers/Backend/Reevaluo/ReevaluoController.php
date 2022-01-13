<?php

namespace App\Http\Controllers\Backend\Reevaluo;

use App\Http\Controllers\Controller;
use App\Models\BienesInmuebles;
use App\Models\BienesMuebles;
use App\Models\ReevaluoInmueble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ReevaluoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('backend.admin.principal.reevaluo.vistareevaluo');
    }

    public function tablaRegistros(){
        $listaInmueble = ReevaluoInmueble::all();

        $dataArray = array();

        foreach ($listaInmueble as $ll) {

            $fecha = "";
            if($ll->fecha != null){
                $fecha = date("d-m-Y", strtotime($ll->fecha));
            }

            $datos = BienesInmuebles::where('id', $ll->id_bieninmueble)->first();

            $dataArray[] = [
                'id' => $ll->id,
                'codigo' => $datos->codigo,
                'descripcion' => $datos->descripcion,
                'valornuevo' => $ll->valornuevo,
                'tipo' => 'Bien Inmueble',
                'documento' => $ll->documento,
                'fecha' => $fecha,
            ];
        }

        usort($dataArray, array( $this, 'sortDate' ));

        return view('backend.admin.principal.reevaluo.tabla.tablareevaluo', compact('dataArray'));
    }

    public function descargarDocumentoReevaluo($id, $tipo){

        if($tipo == 1){
            $url = ReevaluoInmueble::where('id', $id)->pluck('documento')->first();
        }
        else{
            $url = ReevaluoInmueble::where('id', $id)->pluck('documento')->first();
        }

        $pathToFile = "storage/archivos/".$url;

        $extension = pathinfo(($pathToFile), PATHINFO_EXTENSION);

        $nombre = "Documento." . $extension;

        return response()->download($pathToFile, $nombre);
    }

    function vistaAgregar(){
        return view('backend.admin.principal.reevaluo.vistaagregarreevaluo');
    }

    public function busquedaNombreInmueble(Request $request){

        if($request->get('query')){
            $query = $request->get('query');
            $data = BienesInmuebles::where('descripcion', 'LIKE', "%{$query}%")->take(25)->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            $tiene = true;
            foreach($data as $row){

                if(!empty($row)){
                    $tiene = false;
                    if($row->valor != null){
                        $valor = $row->valor;
                    }else{
                        $valor = '';
                    }

                    $output .= '
                 <li onclick="modificarValor('.$row->id.','.$valor.')"><a href="#">'.$row->descripcion.'</a></li>
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

        if($info = BienesInmuebles::where('id', $request->id)->first()){

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
                    $co = new ReevaluoInmueble();
                    $co->id_bieninmueble = $info->id;
                    $co->valornuevo = $request->valornuevo;
                    $co->observaciones = $request->observaciones;
                    $co->fecha = $request->fecha;
                    $co->documento = $nomDocumento;

                    if($co->save()){return ['success' => 2];}else{return ['success' => 3];}
                }else{
                    return ['success' => 3];
                }

            }else{
                $co = new ReevaluoInmueble();
                $co->id_bieninmueble = $info->id;
                $co->valornuevo = $request->valornuevo;
                $co->observaciones = $request->observaciones;
                $co->fecha = $request->fecha;

                if($co->save()){return ['success' => 2];}else{return ['success' => 3];}
            }

        }else{
            return ['success' => 1];
        }
    }

    public function borrarRegistro(Request $request){

        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if($data = ReevaluoInmueble::where('id', $request->id)->first()){

            $documentoOld = $data->documento;

            ReevaluoInmueble::where('id', $request->id)->delete();

            // borrar documento
            if(Storage::disk('archivos')->exists($documentoOld)){
                Storage::disk('archivos')->delete($documentoOld);
            }

            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }

    function vistaEditar($id){

        $info = ReevaluoInmueble::where('id', $id)->first();
        $data = BienesInmuebles::where('id', $info->id_bieninmueble)->first();
        $nombre = $data->descripcion;
        $idbien = $data->id;

        return view('backend.admin.principal.reevaluo.vistaeditarreevaluo', compact('info', 'nombre', 'id', 'idbien'));
    }

    public function editarRegistro(Request $request){

        // buscar si existe el id bien
        if($info = BienesInmuebles::where('id', $request->idbien)->first()){
            if($data = ReevaluoInmueble::where('id', $request->id)->first()){

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

                        ReevaluoInmueble::where('id', $request->id)->update([
                            'id_bieninmueble' => $info->id,
                            'valornuevo' => $request->valornuevo,
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

                    ReevaluoInmueble::where('id', $request->id)->update([
                        'id_bieninmueble' => $info->id,
                        'valornuevo' => $request->valornuevo,
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


    public function sortDate($a, $b){
        //if($a['fecha'] != null && $b['fecha'] != null) {
        if (strtotime($a['fecha']) == strtotime($b['fecha'])) return 0;

        // con el simbolo > vamos a ordenar que las Fechas ultimas sean la primera posicion
        // con el simbolo < vamos a ordenar que las Fechas primeras este en la primera posicion
        return (strtotime($a['fecha']) > strtotime($b['fecha'])) ? -1 : 1;
        //}
    }
}
