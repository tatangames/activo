<?php

namespace App\Http\Controllers\Backend\Traslado;

use App\Http\Controllers\Controller;
use App\Models\BienesMuebles;
use App\Models\BienesVehiculo;
use App\Models\Departamento;
use App\Models\Descriptor;
use App\Models\TrasladoMaquinaria;
use App\Models\TrasladoMueble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TrasladoController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('backend.admin.principal.traslado.vistatraslado');
    }

    public function tablaRegistros(){

        $listaMueble = TrasladoMueble::all();
        $listaMaquina = TrasladoMaquinaria::all();

        $dataArray = array();

        foreach ($listaMueble as $ll) {

            $fecha = "";
            if($ll->fechatraslado != null){
                $fecha = date("d-m-Y", strtotime($ll->fechatraslado));
            }

            $datos = BienesMuebles::where('id', $ll->id_bienmueble)->first();
            $infoenvia = Departamento::where('id', $ll->id_deptoenvia)->first();
            $inforecibe = Departamento::where('id', $ll->id_deptorecibe)->first();

            $dataArray[] = [
                'id' => $ll->id,
                'codigo' => $datos->codigo,
                'descripcion' => $datos->descripcion,
                'envia' => $infoenvia->nombre,
                'recibe' => $inforecibe->nombre,
                'fecha' => $fecha,
                'bien' => 'Bien Mueble',
                'tipo' => 1
            ];
        }

        foreach ($listaMaquina as $llMa) {

            $fecha = "";
            if($llMa->fechatraslado != null) {
                $fecha = date("d-m-Y", strtotime($llMa->fechatraslado));
            }

            $datos = BienesVehiculo::where('id', $llMa->id_bienvehiculo)->first();
            $infoenvia = Departamento::where('id', $llMa->id_deptoenvia)->first();
            $inforecibe = Departamento::where('id', $llMa->id_deptorecibe)->first();

            $dataArray[] = [
                'id' => $llMa->id,
                'codigo' => $datos->codigo,
                'descripcion' => $datos->descripcion,
                'envia' => $infoenvia->nombre,
                'recibe' => $inforecibe->nombre,
                'fecha' => $fecha,
                'bien' => 'Bien Maquinaria',
                'tipo' => 2
            ];
        }

        return view('backend.admin.principal.traslado.tabla.tablatraslado', compact('dataArray'));
    }

    function vistaAgregar(){
        $departamento = Departamento::orderBy('nombre')->get();
        return view('backend.admin.principal.traslado.vistaagregartraslado', compact('departamento'));
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
                 <li onclick="modificarValor('.$row->id.','.$row->id_departamento.')"><a href="#">'. $row->descripcion.'</a></li>
                  <hr>
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

            if($info = BienesMuebles::where('id', $request->idglobal)->first()){

                DB::beginTransaction();

                try {

                    $co = new TrasladoMueble();
                    $co->id_bienmueble = $info->id;
                    $co->id_deptoenvia = $request->envia;
                    $co->id_deptorecibe = $request->recibe;
                    $co->fechatraslado = $request->fecha;

                    if($co->save()){

                        $depa = Departamento::where('id', $request->recibe)->first();
                        $descrip = Descriptor::where('id', $info->id_descriptor)->first();

                        $codigo = $depa->codigo . '-' . $descrip->codigodes . '-' . $info->correlativo;

                        // modificar
                        BienesMuebles::where('id', $request->idglobal)->update([
                            'id_departamento' => $request->recibe,
                            'codigo' => $codigo
                        ]);

                        DB::commit();
                        return ['success' => 2];
                    }else{
                        return ['success' => 3];
                    }

                } catch(\Throwable $e){
                    DB::rollback();
                    return ['success' => 3];
                }

            }else{
                return ['success' => 1];
            }
        }

        else if($request->tipo == 2){ // maquinaria

            if($info = BienesVehiculo::where('id', $request->idglobal)->first()){

                DB::beginTransaction();

                try {

                    $co = new TrasladoMaquinaria();
                    $co->id_bienvehiculo = $info->id;
                    $co->id_deptoenvia = $request->envia;
                    $co->id_deptorecibe = $request->recibe;
                    $co->fechatraslado = $request->fecha;

                    if($co->save()){

                        // modificar solo departamento
                        BienesVehiculo::where('id', $request->idglobal)->update([
                            'id_departamento' => $request->recibe,
                        ]);

                        DB::commit();
                        return ['success' => 2];
                    }else{
                        return ['success' => 3];
                    }

                } catch(\Throwable $e){
                    DB::rollback();
                    return ['success' => 3];
                }

            }else{
                return ['success' => 1];
            }

        }else{
            return ['success' => 3];
        }
    }


    function vistaEditar($id, $valor){

        $fecha = "";

        if($valor == 1){
            $info = TrasladoMueble::where('id', $id)->first();
            $data = BienesMuebles::where('id', $info->id_bienmueble)->first();
            $bien = $data->descripcion;
            if($info->fechatraslado != null){
                $fecha = $info->fechatraslado;
            }

        }
        else if($valor == 2){
            $info = TrasladoMaquinaria::where('id', $id)->first();
            $data = BienesVehiculo::where('id', $info->id_bienvehiculo)->first();
            $bien = $data->descripcion;
            if($info->fechatraslado != null){
                $fecha = $info->fechatraslado;
            }
        }
        else{
            $info = TrasladoMueble::where('id', $id)->first();
            $data = BienesMuebles::where('id', $info->id_bienmueble)->first();
            $bien = $data->descripcion;
            if($info->fechatraslado != null){
                $fecha = $info->fechatraslado;
            }
        }



        return view('backend.admin.principal.traslado.vistaeditartraslado', compact('id', 'valor', 'bien', 'fecha'));
    }

    public function editarRegistro(Request $request){

        if($request->valor == 1){ // mueble

            if(TrasladoMueble::where('id', $request->id)->first()){
                TrasladoMueble::where('id', $request->id)->update([
                    'fechatraslado' => $request->fecha,
                ]);

                return ['success' => 1];
            }else{
                return ['success' => 2];
            }
        }

        else if($request->valor == 2){ // vehiculo y maquinaria

            if(TrasladoMaquinaria::where('id', $request->id)->first()){
                TrasladoMaquinaria::where('id', $request->id)->update([
                    'fechatraslado' => $request->fecha,
                ]);

                return ['success' => 1];
            }else{
                return ['success' => 2];
            }
        }

        else{
            if(TrasladoMueble::where('id', $request->id)->first()){
                TrasladoMueble::where('id', $request->id)->update([
                    'fechatraslado' => $request->fecha,
                ]);

                return ['success' => 1];
            }else{
                return ['success' => 2];
            }
        }

    }

}
