<?php

namespace App\Http\Controllers\Backend\Venta;

use App\Http\Controllers\Controller;
use App\Models\BienesInmuebles;
use App\Models\BienesMuebles;
use App\Models\BienesVehiculo;
use App\Models\VentaInmueble;
use App\Models\VentaMaquinaria;
use App\Models\VentaMueble;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class VentaController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('backend.admin.principal.venta.vistaventa');
    }

    public function tablaRegistros(){
        $listaMueble = VentaMueble::all();
        $listaInmueble = VentaInmueble::all();
        $listaMaquina = VentaMaquinaria::all();

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
                'precio' => $ll->precio,
                'tipo' => 'Bien Mueble',
                'doc' => 1, // para saber que documento descargar
                'documento' => $ll->documento,
                'fecha' => $fecha,
            ];
        }

        foreach ($listaInmueble as $llM) {

            $fecha = "";
            if($llM->fecha != null) {
                $fecha = date("d-m-Y", strtotime($llM->fecha));
            }

            $datos = BienesInmuebles::where('id', $llM->id_bieninmueble)->first();

            $dataArray[] = [
                'id' => $llM->id,
                'codigo' => $datos->codigo,
                'descripcion' => $datos->descripcion,
                'precio' => $llM->precio,
                'tipo' => 'Bien Inmueble',
                'doc' => 2, // para saber que documento descargar
                'documento' => $llM->documento,
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
                'precio' => $llMa->precio,
                'tipo' => 'Vehículos y Maquinaria',
                'doc' => 3, // para saber que documento descargar
                'documento' => $llMa->documento,
                'fecha' => $fecha,
            ];
        }

        usort($dataArray, array( $this, 'sortDate' ));

        return view('backend.admin.principal.venta.tabla.tablaventa', compact('dataArray'));
    }

    function vistaAgregar(){
        return view('backend.admin.principal.venta.vistaagregarventa');
    }

    public function busquedaNombreMueble(Request $request){

        if($request->get('query')){
            $query = $request->get('query');
            $data = BienesMuebles::where('descripcion', 'LIKE', "%{$query}%")->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            $tiene = true;
            foreach($data as $row){

                if(!empty($row)){
                    $tiene = false;
                    $output .= '
                 <li onclick="modificarValor('.$row->id.')"><a href="#">'.$row->descripcion.'</a></li>
                ';
                }
            }
            $output .= '</ul>';
            if($tiene){
                $output = '';
            }
            echo $output;
        }
    }

    public function busquedaInmueble(Request $request){

        if($request->get('query')){
            $query = $request->get('query');
            $data = BienesInmuebles::where('descripcion', 'LIKE', "%{$query}%")->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            $tiene = true;
            foreach($data as $row){

                if(!empty($row)){
                    $tiene = false;
                    $output .= '
                 <li onclick="modificarValor('.$row->id.')"><a href="#">'.$row->descripcion.'</a></li>
                ';
                }
            }
            $output .= '</ul>';
            if($tiene){
                $output = '';
            }
            echo $output;
        }
    }

    public function busquedaMaquinaria(Request $request){

        if($request->get('query')){
            $query = $request->get('query');
            $data = BienesVehiculo::where('descripcion', 'LIKE', "%{$query}%")->get();
            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
            $tiene = true;
            foreach($data as $row){

                if(!empty($row)){
                    $tiene = false;
                    $output .= '
                 <li onclick="modificarValor('.$row->id.')"><a href="#">'.$row->descripcion.'</a></li>
                ';
                }
            }
            $output .= '</ul>';
            if($tiene){
                $output = '';
            }
            echo $output;
        }
    }

    public function descargarDocumentoVenta($id, $tipo){

        if($tipo == 1){
            $url = VentaMueble::where('id', $id)->pluck('documento')->first();
        }
        else if($tipo == 2){
            $url = VentaInmueble::where('id', $id)->pluck('documento')->first();
        }
        else if($tipo == 3){
            $url = VentaMaquinaria::where('id', $id)->pluck('documento')->first();
        }else{
            $url = VentaMueble::where('id', $id)->pluck('documento')->first();
        }

        $pathToFile = "storage/archivos/".$url;

        $extension = pathinfo(($pathToFile), PATHINFO_EXTENSION);

        $nombre = "Documento." . $extension;

        return response()->download($pathToFile, $nombre);
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
                        $co = new VentaMueble();
                        $co->precio = $request->precio;
                        $co->observaciones = $request->observaciones;
                        $co->id_bienmueble = $info->id;
                        $co->documento = $nomDocumento;
                        $co->fecha = $request->fecha;
                        if($co->save()){return ['success' => 2];}else{return ['success' => 3];}
                    }else{
                        return ['success' => 3];
                    }

                }else{
                    $co = new VentaMueble();
                    $co->precio = $request->precio;
                    $co->observaciones = $request->observaciones;
                    $co->id_bienmueble = $info->id;
                    $co->fecha = $request->fecha;
                    if($co->save()){return ['success' => 2];}else{return ['success' => 3];}
                }

            }else{
                return ['success' => 1];
            }
        }

        else if($request->tipo == 2){ // inmuebles

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
                        $co = new VentaInmueble();
                        $co->precio = $request->precio;
                        $co->observaciones = $request->observaciones;
                        $co->id_bieninmueble = $info->id;
                        $co->documento = $nomDocumento;
                        $co->fecha = $request->fecha;
                        if($co->save()){return ['success' => 2];}else{return ['success' => 3];}
                    }else{
                        return ['success' => 3];
                    }

                }else{
                    $co = new VentaInmueble();
                    $co->precio = $request->precio;
                    $co->observaciones = $request->observaciones;
                    $co->id_bieninmueble = $info->id;
                    $co->fecha = $request->fecha;
                    if($co->save()){return ['success' => 2];}else{return ['success' => 3];}
                }

            }else{
                return ['success' => 1];
            }

        }
        else if($request->tipo == 3){ // maquinaria

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
                        $co = new VentaMaquinaria();
                        $co->precio = $request->precio;
                        $co->observaciones = $request->observaciones;
                        $co->id_bienvehiculo = $info->id;
                        $co->documento = $nomDocumento;
                        $co->fecha = $request->fecha;
                        if($co->save()){return ['success' => 2];}else{return ['success' => 3];}
                    }else{
                        return ['success' => 3];
                    }

                }else{
                    $co = new VentaMaquinaria();
                    $co->precio = $request->precio;
                    $co->observaciones = $request->observaciones;
                    $co->id_bienvehiculo = $info->id;
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

    function vistaEditar($id, $valor){

        if($valor == 1){
            $info = VentaMueble::where('id', $id)->first();
            $data = BienesMuebles::where('id', $info->id_bienmueble)->first();
            $nombre = $data->descripcion;
            $idbien = $data->id;
            $tipo = "Bien Mueble";
        }
        else if($valor == 2){
            $info = VentaInmueble::where('id', $id)->first();
            $data = BienesInmuebles::where('id', $info->id_bieninmueble)->first();
            $nombre = $data->descripcion;
            $idbien = $data->id;
            $tipo = "Bien Inmueble";
        }
        else if($valor == 3){
            $info = VentaMaquinaria::where('id', $id)->first();
            $data = BienesVehiculo::where('id', $info->id_bienvehiculo)->first();
            $nombre = $data->descripcion;
            $idbien = $data->id;
            $tipo = "Bien Vehículos y Maquinaria";
        }
        else{
            $info = VentaMueble::where('id', $id)->first();
            $data = BienesMuebles::where('id', $info->id_bienmueble)->first();
            $nombre = $data->descripcion;
            $idbien = $data->id;
            $tipo = "Bien Mueble";
        }

        return view('backend.admin.principal.venta.vistaeditarventa', compact('info', 'tipo', 'nombre', 'id', 'idbien', 'valor'));
    }

    public function editarRegistro(Request $request){

        if($request->valor == 1){ // mueble

            // buscar si existe el id bien
            if($info = BienesMuebles::where('id', $request->idbien)->first()){
                if($data = VentaMueble::where('id', $request->id)->first()){

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

                            VentaMueble::where('id', $request->id)->update([
                                'precio' => $request->precio,
                                'observaciones' => $request->observaciones,
                                'id_bienmueble' => $info->id,
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

                        VentaMueble::where('id', $request->id)->update([
                            'precio' => $request->precio,
                            'observaciones' => $request->observaciones,
                            'id_bienmueble' => $info->id,
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
        else if($request->valor == 2){ // inmueble

            if($info = BienesInmuebles::where('id', $request->idbien)->first()){
                if($data = VentaInmueble::where('id', $request->id)->first()){

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

                            VentaInmueble::where('id', $request->id)->update([
                                'precio' => $request->precio,
                                'observaciones' => $request->observaciones,
                                'id_bieninmueble' => $info->id,
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

                        VentaInmueble::where('id', $request->id)->update([
                            'precio' => $request->precio,
                            'observaciones' => $request->observaciones,
                            'id_bieninmueble' => $info->id,
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
        else if($request->valor == 3){ // vehiculo y maquinaria

            if($info = BienesVehiculo::where('id', $request->idbien)->first()){
                if($data = VentaMaquinaria::where('id', $request->id)->first()){

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

                            VentaMaquinaria::where('id', $request->id)->update([
                                'precio' => $request->precio,
                                'observaciones' => $request->observaciones,
                                'id_bienvehiculo' => $info->id,
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

                        VentaMaquinaria::where('id', $request->id)->update([
                            'precio' => $request->precio,
                            'observaciones' => $request->observaciones,
                            'id_bienvehiculo' => $info->id,
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
                if($data = VentaMueble::where('id', $request->id)->first()){

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

                            VentaMueble::where('id', $request->id)->update([
                                'precio' => $request->precio,
                                'observaciones' => $request->observaciones,
                                'id_bienmueble' => $info->id,
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

                        VentaMueble::where('id', $request->id)->update([
                            'precio' => $request->precio,
                            'observaciones' => $request->observaciones,
                            'id_bienmueble' => $info->id,
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
            if($data = VentaMueble::where('id', $request->id)->first()){

                $documentoOld = $data->documento;

                VentaMueble::where('id', $request->id)->delete();

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
            if($data = VentaInmueble::where('id', $request->id)->first()){

                $documentoOld = $data->documento;

                VentaInmueble::where('id', $request->id)->delete();

                // borrar documento
                if(Storage::disk('archivos')->exists($documentoOld)){
                    Storage::disk('archivos')->delete($documentoOld);
                }

                return ['success' => 1];
            }else{
                return ['success' => 2];
            }
        }
        else if($request->valor == 3){
            if($data = VentaMaquinaria::where('id', $request->id)->first()){

                $documentoOld = $data->documento;

                VentaMaquinaria::where('id', $request->id)->delete();

                // borrar documento
                if(Storage::disk('archivos')->exists($documentoOld)){
                    Storage::disk('archivos')->delete($documentoOld);
                }

                return ['success' => 1];
            }else{
                return ['success' => 2];
            }
        }else{
            if($data = VentaMueble::where('id', $request->id)->first()){

                $documentoOld = $data->documento;

                VentaMueble::where('id', $request->id)->delete();

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
