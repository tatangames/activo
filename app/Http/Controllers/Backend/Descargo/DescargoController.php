<?php

namespace App\Http\Controllers\Backend\Descargo;

use App\Http\Controllers\Controller;
use App\Models\BienesMuebles;
use App\Models\BienesVehiculo;
use App\Models\DescargoMaquinaria;
use App\Models\DescargoMueble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DescargoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('backend.admin.principal.descargo.vistadescargo');
    }

    public function tablaRegistros(){
        $listaMueble = DescargoMueble::all();
        $listaMaquina = DescargoMaquinaria::all();

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
                'valor' => $ll->valor,
                'observaciones' => $ll->observaciones,
                'tipo' => 'Bien Mueble',
                'doc' => 1, // para saber que documento descargar
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
                'observaciones' => $llMa->observaciones,
                'valor' => $llMa->valor,
                'tipo' => 'Vehículos y Maquinaria',
                'doc' => 2, // para saber que documento descargar
                'fecha' => $fecha,
            ];
        }

        usort($dataArray, array( $this, 'sortDate' ));

        return view('backend.admin.principal.descargo.tabla.tabladescargo', compact('dataArray'));
    }

    function vistaAgregar(){
        return view('backend.admin.principal.descargo.vistaagregardescargo');
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

    public function busquedaNombreMaquinaria(Request $request){

        if($request->get('query')){
            $query = $request->get('query');
            $data = BienesVehiculo::where('descripcion', 'LIKE', "%{$query}%")->take(25)->get();
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

        if($request->tipo == 1){ // muebles

            if($info = BienesMuebles::where('id', $request->id)->first()){

                $co = new DescargoMueble();
                $co->id_bienmueble = $info->id;
                $co->valor = $request->valor;
                $co->observaciones = $request->observaciones;
                $co->fecha = $request->fecha;

                if($co->save()){return ['success' => 2];}else{return ['success' => 3];}
            }else{
                return ['success' => 1];
            }
        }

        else if($request->tipo == 2){ // maquinaria

            if($info = BienesVehiculo::where('id', $request->id)->first()){

                $co = new DescargoMaquinaria();
                $co->id_bienvehiculo = $info->id;
                $co->valor = $request->valor;
                $co->observaciones = $request->observaciones;
                $co->fecha = $request->fecha;

                if($co->save()){return ['success' => 2];}else{return ['success' => 3];}
            }else{
                return ['success' => 1];
            }

        }else{
            return ['success' => 3];
        }
    }

    function vistaEditar($id, $valor){

        if($valor == 1){
            $info = DescargoMueble::where('id', $id)->first();
            $data = BienesMuebles::where('id', $info->id_bienmueble)->first();
            $nombre = $data->descripcion;
            $idbien = $data->id;
            $tipo = "Bien Mueble";
        }
        else if($valor == 2){
            $info = DescargoMaquinaria::where('id', $id)->first();
            $data = BienesVehiculo::where('id', $info->id_bienvehiculo)->first();
            $nombre = $data->descripcion;
            $idbien = $data->id;
            $tipo = "Bien Vehículos y Maquinaria";
        }
        else{
            $info = DescargoMueble::where('id', $id)->first();
            $data = BienesMuebles::where('id', $info->id_bienmueble)->first();
            $nombre = $data->descripcion;
            $idbien = $data->id;
            $tipo = "Bien Mueble";
        }

        return view('backend.admin.principal.descargo.vistaeditardescargo', compact('info', 'tipo', 'nombre', 'id', 'idbien', 'valor'));
    }

    public function editarRegistro(Request $request){

        if($request->valor == 1){ // mueble

            // buscar si existe el id bien
            if($info = BienesMuebles::where('id', $request->idbien)->first()){
                if(DescargoMueble::where('id', $request->id)->first()){

                    DescargoMueble::where('id', $request->id)->update([
                        'id_bienmueble' => $info->id,
                        'valor' => $request->valor,
                        'observaciones' => $request->observaciones,
                        'fecha' => $request->fecha,
                    ]);

                    return ['success' => 2];
                }else{
                    return ['success' => 3];
                }
            }else{
                return ['success' => 1];
            }
        }

        else if($request->valor == 2){ // vehiculo y maquinaria

            if($info = BienesVehiculo::where('id', $request->idbien)->first()){
                if(DescargoMaquinaria::where('id', $request->id)->first()){

                    DescargoMaquinaria::where('id', $request->id)->update([
                        'id_bienvehiculo' => $info->id,
                        'valor' => $request->valor,
                        'observaciones' => $request->observaciones,
                        'fecha' => $request->fecha,
                    ]);

                    return ['success' => 2];
                }else{
                    return ['success' => 3];
                }
            }else{
                return ['success' => 1];
            }
        }

        else{

            // buscar si existe el id bien
            if($info = BienesMuebles::where('id', $request->idbien)->first()){
                if(DescargoMueble::where('id', $request->id)->first()){

                    DescargoMueble::where('id', $request->id)->update([
                        'id_bienmueble' => $info->id,
                        'valor' => $request->valor,
                        'observaciones' => $request->observaciones,
                        'fecha' => $request->fecha,
                    ]);

                    return ['success' => 2];
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
            if(DescargoMueble::where('id', $request->id)->first()){

                DescargoMueble::where('id', $request->id)->delete();

                return ['success' => 1];
            }else{
                return ['success' => 2];
            }
        }
        else if($request->valor == 2){
            if(DescargoMaquinaria::where('id', $request->id)->first()){

                DescargoMaquinaria::where('id', $request->id)->delete();

                return ['success' => 1];
            }else{
                return ['success' => 2];
            }
        }else{
            if(DescargoMueble::where('id', $request->id)->first()){

                DescargoMueble::where('id', $request->id)->delete();

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
