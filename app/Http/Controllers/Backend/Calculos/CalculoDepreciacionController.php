<?php

namespace App\Http\Controllers\Backend\Calculos;

use App\Http\Controllers\Controller;
use App\Models\BienesMuebles;
use App\Models\BienesVehiculo;
use App\Models\CodigoContable;
use App\Models\CodigoDepreciacion;
use App\Models\Departamento;
use App\Models\HistorialdaMueble;
use App\Models\SustitucionMaquinaria;
use App\Models\SustitucionMueble;
use DateTime;
use Illuminate\Http\Request;

class CalculoDepreciacionController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('backend.admin.calculos.depreciacion.vistadepreciacion');
    }

    public function verificarCodigo(Request $request){

        if(BienesMuebles::where('codigo', $request->codigo)->first()){
            return ['success' => 1];
        }
        else if(BienesVehiculo::where('codigo', $request->codigo)->first()){
            return ['success' => 1];
        }else{
            return ['success' => 2];
        }

    }

    // código del bien:
    public function indexReporteCodigo($codigo){

        // solo bienes muebles y maquinaria

        if($info = BienesMuebles::where('codigo', $codigo)
            ->where('valor', '>', '600')
            ->first()){

            $infoConta = CodigoContable::where('id', $info->id_codcontable)->first();
            $infoDepre = CodigoDepreciacion::where('id', $info->id_coddepreci)->first();
            $infoUnidad = Departamento::where('id', $info->id_departamento)->first();

            $contable = $infoConta->nombre . " (" . $infoConta->codconta . ")";
            $depreciacion = $infoDepre->nombre . " (" . $infoConta->codconta . ")";

            $fecha = $info->fechacompra = date("d-m-Y", strtotime($info->fechacompra));

            // calculos
            //tiempo util
            $fechacompra = new DateTime($info->fechacompra);
            $fechafab = new DateTime('-12-31');  // vacio

            $interval = $fechacompra->diff($fechafab);

            // 0.13
            $tiempoutil = round($interval->format('%a')/365,2);

            //anios pendientes
            if($info->id_tipocompra == 1 ){ // nuevo
                $aniospen = $info->vidautil;
            }else{
                // usado
                $aniospen = $info->vidautil - $tiempoutil;
            }

            $valorres = $info->valor * ($info->valresidual / 100);
            $valordepre = $info->valor - $valorres;

            //depreciacion anual
            if($aniospen>0){
                $depanual = number_format((float)$valordepre / $aniospen, 2, '.', ',');
            }else {
                $depanual = 0;
            }

            // protegerse de negativos
            if($aniospen < 0){
                $aniospen = 0;
            }

            /*********************************** SI HAY REPOSICION VITAL ********************************/////

            $repvit = SustitucionMueble::where('id_bienmueble', $info->id)->get();

            foreach($repvit as $datorep){
                $nuevoval = floatval($datorep->piezanueva)+floatval($datorep->valorajustado);
                $nvalresidual = $nuevoval * ($info->valresidual / 100);
                $newvaldepre = $nuevoval - round($nvalresidual,2);
                $newdepreanual = $newvaldepre / $datorep->vidautil;
                $newvalbien = $info->valor + floatval($datorep->piezanueva) - floatval($datorep->piezasustituida);

                $datorep->dfechamodificacion = date("d-m-Y", strtotime($datorep->fecha));
                $datorep->dnuevovalor = "$" . number_format((float) $nuevoval, 2, '.', ',');

                $datorep->dpiezasustituida = "$" . number_format((float) $datorep->piezasustituida, 2, '.', ',');
                $datorep->dvalorresidual = "$" . number_format((float) $nvalresidual, 2, '.', ',');

                $datorep->dpiezanueva = "$" . number_format((float) $datorep->piezanueva, 2, '.', ',');
                $datorep->dvalordepreciar = "$" . number_format((float) $newvaldepre, 2, '.', ',');

                $datorep->dnuevovalorbien = "$" . number_format((float) $newvalbien, 2, '.', ',');

                $datorep->dvalorajustado = "$" . number_format((float) $datorep->valorajustado, 2, '.', ',');
                $datorep->ddepreciacionanual = "$" . number_format((float) $newdepreanual, 2, '.', ',');
            }

            $datos = array(
                'contable' => $contable,
                'depreciacion' => $depreciacion,
                'unidad' => $infoUnidad->nombre,
                'anio' => $fecha,
                'valorresidual' => number_format((float)$valorres, 2, '.', ','),
                'valoradepreciar' => number_format((float)$valordepre, 2, '.', ','),
                'aniopendiente' => $aniospen,
                'depanual' => $depanual,
            );

            /***************************************  CALCULOS GENERALES DE DEPRECIACION NORMAL  ****************************************/

            $aniocompra = date("Y", strtotime($info->fechacompra));

            if($aniocompra == null){
                return "Fecha de Compra es requerido";
            }

            $contador = round($aniospen) + 7;

            //por si la reposicion fue cuando ya se habia depreciado por completo el bien
            $vidaextra = SustitucionMueble::where('id_bienmueble', $info->id)->sum('vidautil');

            if($vidaextra > 0){
                $contador = $contador + floatval($vidaextra);
            }

            //---- CALCULO -----
            $numdias = $aniospen * 365;
            //dias del año UNO
            $fechafin = new DateTime($aniocompra.'-12-31');
            $interval2 = $fechafin->diff($fechacompra);
            $diasaniouno = $interval2->format('%a');

            //dias restantes / anios restantes
            $diasrestantes = $numdias - $diasaniouno;

            //depreciacion por dia
            $deppordia = number_format((float)($valordepre / $aniospen) / 365, 7, '.', ',');

            $i = 0;
            $depacumulada = 0;
            $depanualuno = $diasaniouno * $deppordia;

            $depanualfin = 0;
            $dataArray = array();

            while($contador > 0){
                $array["anio"] = $aniocompra;
                $fechaini = $array['anio'].'-01-01';
                $fechafin = $array['anio'].'-12-31';
                $valorbien = $info->valor;

                /******************************  CALCULO DE DEPRECIACION SI HAY REPOSICION VITAL ****************************/

                if($repvitanio = SustitucionMueble::where('id_bienmueble', $info->id)
                    ->whereBetween('fecha', array($fechaini, $fechafin))
                    ->first()){

                    $nuevoval = floatval($repvitanio->piezanueva) + floatval($repvitanio->valorajustado);
                    $nvalresidual = $nuevoval * ($info->valresidual / 100);
                    $newvaldepre = $nuevoval - round($nvalresidual,2);
                    $newdepreanual = $newvaldepre / $repvitanio->vidautil;
                    //$newvalbien = $info->valor + floatval($repvitanio->piezanueva) - floatval($repvitanio->piezasustituida);

                    //datos para calculos
                    $numdiasrep = floatval($repvitanio->vidautil) * 365;
                    $fechafin2 = new DateTime($fechafin);
                    $fecharep = new DateTime($repvitanio->fecha);
                    $interval22 = $fechafin2->diff($fecharep);
                    $diasaniounorep = $interval22->format('%a');

                    //dias de depreciacion antes de la reposicion
                    if($depanualfin > 0){
                        $diasantes = 365 - $diasaniounorep;
                        $depanterior = $diasantes * $deppordia;
                        $new2 = $valorbien - $depacumulada - $depanterior;

                        $dataArray[] = [
                            'aniocompra' => $aniocompra,
                            'depanterior' => number_format((float)$depanterior, 2, '.', ','),
                            'depacumulada' => number_format((float)$depacumulada+$depanterior, 2, '.', ','),
                            'new2' => number_format((float)$new2, 2, '.', ','),
                            'color' => 1, // gris
                        ];

                        $array["depanterior"] = $depanterior;
                    }

                    //dias restantes / anios restantes
                    $diasrestantes = $numdiasrep - $diasaniounorep;

                    $contador = floatval($repvitanio->vidautil) + 1;
                    $deppordia = number_format(($newdepreanual) / 365,7);
                    //reinicio datos
                    $depanualuno = $diasaniounorep * $deppordia;


                    $depacumulada = 0;
                    $i = 0;
                    $valorbien = round(floatval($nuevoval),2);
                    $nuevovalporrep = $valorbien;

                    // Borrar historial de depreciacion de los años restantes
                    $aniob = intval($aniocompra);
                    $bandera = $contador + 1;
                    while($bandera >= 0){

                        HistorialdaMueble::where('id_bienmueble', $info->id)
                            ->where('anio', $aniob)->delete();

                        $bandera --;
                        $aniob ++;
                    }
                }

                // PARA EL CALCULO DE LA DEPRECIACION ANUAL DE LA TABLA
                if($i == 0 ){
                    $depanualfin = $depanualuno;
                } else {
                    if ($diasrestantes >= 365){
                        $depanualfin = $deppordia*365;
                        $diasrestantes = $diasrestantes - 365;
                    } else {
                        $depanualfin = $deppordia*$diasrestantes;
                        if($depanualfin <= 0 ){
                            $depanualfin = 0 ;
                        }
                        $diasrestantes = $diasrestantes - 365;
                    }
                }

                //si hay depreciacion anterior que sume las dos depreciaciones del mismo anio para guardarla asi en la db
                if(isset($array["depanterior"]) && $array["depanterior"] != 0){
                    $array["depanual"] = $depanualfin + floatval($array["depanterior"]);
                }else{
                    $array["depanual"] = $depanualfin;
                }

                //GUARDAR DEPRECIACION ACUMULADA EN EL ARRAY TABLA
                if($i == 0){
                    $depacumulada += $depanualuno;
                }else{
                    if($depanualfin <= 0 ){
                        $depacumulada = 0;
                    }
                    $depacumulada += $depanualfin;
                }

                $array["depacumulada"] = $depacumulada;

                // variable afuera para agregarlo al array
                $varNew2 = 0;

                //GUARDAR VALOR EN LIBROS EN EL ARREGLO Y TABLA
                if ($depanualfin<=0){
                    // nada
                } else{
                    if($i==0){
                        $new = $valorbien - $depanualfin;
                    }else{
                        if(isset($nuevovalporrep) && $nuevovalporrep != NULL){
                            $new = floatval($nuevovalporrep) - $depacumulada;
                        }else{
                            $new = $valorbien - $depacumulada;
                        }
                    }
                    $varNew2 = $new;
                    $array["vallibros"] = $new;
                }

                //*** GUARDAR ARRAY

                $dataArray[] = [
                    'aniocompra' => $aniocompra,
                    'depanterior' => number_format((float)$depanualfin, 2, '.', ','),
                    'depacumulada' => number_format((float)$depacumulada, 2, '.', ','),
                    'new2' => number_format((float)$varNew2, 2, '.', ','),
                    'color' => 2, // sin color
                ];

                $contador--;
                $aniocompra++;
                $i++;
                $array["depanterior"] = 0;
            }

            $idbien = $info->id;

            return view('backend.admin.calculos.depreciacion.vistacalculocodigobienmueble', compact('info', 'datos', 'repvit', 'dataArray', 'idbien'));
        }

        else if($info = BienesVehiculo::where('codigo', $codigo)
            ->where('valor', '>', '600')
            ->first()){

            $infoConta = CodigoContable::where('id', $info->id_codcontable)->first();
            $infoDepre = CodigoDepreciacion::where('id', $info->id_coddepreci)->first();
            $infoUnidad = Departamento::where('id', $info->id_departamento)->first();

            $contable = $infoConta->nombre . " (" . $infoConta->codconta . ")";
            $depreciacion = $infoDepre->nombre . " (" . $infoConta->codconta . ")";

            $fecha = $info->fechacompra = date("d-m-Y", strtotime($info->fechacompra));

            // calculos
            //tiempo util
            $fechacompra = new DateTime($info->fechacompra);
            $fechafab = new DateTime('-12-31');  // vacio

            $interval = $fechacompra->diff($fechafab);

            // 0.13
            $tiempoutil = round($interval->format('%a')/365,2);

            //anios pendientes
            if($info->id_tipocompra == 1 ){ // nuevo
                $aniospen = $info->vidautil;
            }else{
                // usado
                $aniospen = $info->vidautil - $tiempoutil;
            }

            $valorres = $info->valor * ($info->valresidual / 100);
            $valordepre = $info->valor - $valorres;

            //depreciacion anual
            if($aniospen>0){
                $depanual = number_format((float)$valordepre / $aniospen, 2, '.', ',');
            }else {
                $depanual = 0;
            }

            // protegerse de negativos
            if($aniospen < 0){
                $aniospen = 0;
            }

            /*********************************** SI HAY REPOSICION VITAL ********************************/////

            $repvit = SustitucionMueble::where('id_bienmueble', $info->id)->get();

            foreach($repvit as $datorep){
                $nuevoval = floatval($datorep->piezanueva)+floatval($datorep->valorajustado);
                $nvalresidual = $nuevoval * ($info->valresidual / 100);
                $newvaldepre = $nuevoval - round($nvalresidual,2);
                $newdepreanual = $newvaldepre / $datorep->vidautil;
                $newvalbien = $info->valor + floatval($datorep->piezanueva) - floatval($datorep->piezasustituida);

                $datorep->dfechamodificacion = date("d-m-Y", strtotime($datorep->fecha));
                $datorep->dnuevovalor = "$" . number_format((float) $nuevoval, 2, '.', ',');

                $datorep->dpiezasustituida = "$" . number_format((float) $datorep->piezasustituida, 2, '.', ',');
                $datorep->dvalorresidual = "$" . number_format((float) $nvalresidual, 2, '.', ',');

                $datorep->dpiezanueva = "$" . number_format((float) $datorep->piezanueva, 2, '.', ',');
                $datorep->dvalordepreciar = "$" . number_format((float) $newvaldepre, 2, '.', ',');

                $datorep->dnuevovalorbien = "$" . number_format((float) $newvalbien, 2, '.', ',');

                $datorep->dvalorajustado = "$" . number_format((float) $datorep->valorajustado, 2, '.', ',');
                $datorep->ddepreciacionanual = "$" . number_format((float) $newdepreanual, 2, '.', ',');
            }

            $datos = array(
                'contable' => $contable,
                'depreciacion' => $depreciacion,
                'unidad' => $infoUnidad->nombre,
                'anio' => $fecha,
                'valorresidual' => number_format((float)$valorres, 2, '.', ','),
                'valoradepreciar' => number_format((float)$valordepre, 2, '.', ','),
                'aniopendiente' => $aniospen,
                'depanual' => $depanual,
            );

            /***************************************  CALCULOS GENERALES DE DEPRECIACION NORMAL  ****************************************/

            $aniocompra = date("Y", strtotime($info->fechacompra));

            if($aniocompra == null){
                return "Fecha de Compra es requerido";
            }

            $contador = round($aniospen) + 7;

            //por si la reposicion fue cuando ya se habia depreciado por completo el bien
            $vidaextra = SustitucionMaquinaria::where('id_bienvehiculo', $info->id)->sum('vidautil');

            if($vidaextra > 0){
                $contador = $contador + floatval($vidaextra);
            }

            //---- CALCULO -----
            $numdias = $aniospen * 365;
            //dias del año UNO
            $fechafin = new DateTime($aniocompra.'-12-31');
            $interval2 = $fechafin->diff($fechacompra);
            $diasaniouno = $interval2->format('%a');

            //dias restantes / anios restantes
            $diasrestantes = $numdias - $diasaniouno;

            //depreciacion por dia
            $deppordia = number_format((float)($valordepre / $aniospen) / 365, 7, '.', ',');

            $i = 0;
            $depacumulada = 0;
            $depanualuno = $diasaniouno * $deppordia;

            $depanualfin = 0;
            $dataArray = array();

            while($contador > 0){
                $array["anio"] = $aniocompra;
                $fechaini = $array['anio'].'-01-01';
                $fechafin = $array['anio'].'-12-31';
                $valorbien = $info->valor;

                /******************************  CALCULO DE DEPRECIACION SI HAY REPOSICION VITAL ****************************/

                if($repvitanio = SustitucionMaquinaria::where('id_bienvehiculo', $info->id)
                    ->whereBetween('fecha', array($fechaini, $fechafin))
                    ->first()){

                    $nuevoval = floatval($repvitanio->piezanueva) + floatval($repvitanio->valorajustado);
                    $nvalresidual = $nuevoval * ($info->valresidual / 100);
                    $newvaldepre = $nuevoval - round($nvalresidual,2);
                    $newdepreanual = $newvaldepre / $repvitanio->vidautil;
                    //$newvalbien = $info->valor + floatval($repvitanio->piezanueva) - floatval($repvitanio->piezasustituida);

                    //datos para calculos
                    $numdiasrep = floatval($repvitanio->vidautil) * 365;
                    $fechafin2 = new DateTime($fechafin);
                    $fecharep = new DateTime($repvitanio->fecha);
                    $interval22 = $fechafin2->diff($fecharep);
                    $diasaniounorep = $interval22->format('%a');

                    //dias de depreciacion antes de la reposicion
                    if($depanualfin > 0){
                        $diasantes = 365 - $diasaniounorep;
                        $depanterior = $diasantes * $deppordia;
                        $new2 = $valorbien - $depacumulada - $depanterior;

                        $dataArray[] = [
                            'aniocompra' => $aniocompra,
                            'depanterior' => number_format((float)$depanterior, 2, '.', ','),
                            'depacumulada' => number_format((float)$depacumulada+$depanterior, 2, '.', ','),
                            'new2' => number_format((float)$new2, 2, '.', ','),
                            'color' => 1, // gris
                        ];

                        $array["depanterior"] = $depanterior;
                    }

                    //dias restantes / anios restantes
                    $diasrestantes = $numdiasrep - $diasaniounorep;

                    $contador = floatval($repvitanio->vidautil) + 1;
                    $deppordia = number_format(($newdepreanual) / 365,7);
                    //reinicio datos
                    $depanualuno = $diasaniounorep * $deppordia;

                    $depacumulada = 0;
                    $i = 0;
                    $valorbien = round(floatval($nuevoval),2);
                    $nuevovalporrep = $valorbien;

                    // Borrar historial de depreciacion de los años restantes
                    $aniob = intval($aniocompra);
                    $bandera = $contador + 1;
                    while($bandera >= 0){

                        /*HistorialdaMueble::where('id_bienmueble', $info->id)
                            ->where('anio', $aniob)->delete();*/

                        $bandera --;
                        $aniob ++;
                    }
                }

                // PARA EL CALCULO DE LA DEPRECIACION ANUAL DE LA TABLA
                if($i == 0 ){
                    $depanualfin = $depanualuno;
                } else {
                    if ($diasrestantes >= 365){
                        $depanualfin = $deppordia*365;
                        $diasrestantes = $diasrestantes - 365;
                    } else {
                        $depanualfin = $deppordia*$diasrestantes;
                        if($depanualfin <= 0 ){
                            $depanualfin = 0 ;
                        }
                        $diasrestantes = $diasrestantes - 365;
                    }
                }

                //si hay depreciacion anterior que sume las dos depreciaciones del mismo anio para guardarla asi en la db
                if(isset($array["depanterior"]) && $array["depanterior"] != 0){
                    $array["depanual"] = $depanualfin + floatval($array["depanterior"]);
                }else{
                    $array["depanual"] = $depanualfin;
                }

                //GUARDAR DEPRECIACION ACUMULADA EN EL ARRAY TABLA
                if($i == 0){
                    $depacumulada += $depanualuno;
                }else{
                    if($depanualfin <= 0 ){
                        $depacumulada = 0;
                    }
                    $depacumulada += $depanualfin;
                }

                $array["depacumulada"] = $depacumulada;

                // variable afuera para agregarlo al array
                $varNew2 = 0;

                //GUARDAR VALOR EN LIBROS EN EL ARREGLO Y TABLA
                if ($depanualfin<=0){
                    // nada
                } else{
                    if($i==0){
                        $new = $valorbien - $depanualfin;
                    }else{
                        if(isset($nuevovalporrep) && $nuevovalporrep != NULL){
                            $new = floatval($nuevovalporrep) - $depacumulada;
                        }else{
                            $new = $valorbien - $depacumulada;
                        }
                    }
                    $varNew2 = $new;
                    $array["vallibros"] = $new;
                }

                //*** GUARDAR ARRAY

                $dataArray[] = [
                    'aniocompra' => $aniocompra,
                    'depanterior' => number_format((float)$depanualfin, 2, '.', ','),
                    'depacumulada' => number_format((float)$depacumulada, 2, '.', ','),
                    'new2' => number_format((float)$varNew2, 2, '.', ','),
                    'color' => 2, // sin color
                ];

                $contador--;
                $aniocompra++;
                $i++;
                $array["depanterior"] = 0;
            }

            $idbien = $info->id;

            return view('backend.admin.calculos.depreciacion.vistacalculocodigobienvehiculo', compact('info', 'datos', 'repvit', 'dataArray', 'idbien'));
        }
        else{
            // no encontrado
            return view('backend.admin.calculos.depreciacion.vistanoencontrado', compact('codigo'));
        }
    }

    public function guardarHistorialdaMueble(Request $request){

        // solo bienes muebles y maquinaria

        if ($info = BienesMuebles::where('id', $request->id)->first()) {

            //tiempo util
            $fechacompra = new DateTime($info->fechacompra);
            $fechafab = new DateTime('-12-31');  // vacio

            $interval = $fechacompra->diff($fechafab);

            $tiempoutil = round($interval->format('%a') / 365, 2);

            //anios pendientes
            if ($info->id_tipocompra == 1) { // nuevo
                $aniospen = $info->vidautil;
            } else {
                // usado
                $aniospen = $info->vidautil - $tiempoutil;
            }

            $valorres = $info->valor * ($info->valresidual / 100);

            //valor a depreciar: 850 - 85 = 800.00
            $valordepre = $info->valor - $valorres;

            //depreciacion anual
            if ($aniospen > 0) {
                $depanual = number_format((float)$valordepre / $aniospen, 2, '.', ',');
            } else {
                $depanual = 0;
            }

            // protegerse de negativos
            if ($aniospen < 0) {
                $aniospen = 0;
            }

            /*********************************** SI HAY REPOSICION VITAL ********************************/////

            $repvit = SustitucionMueble::where('id_bienmueble', $info->id)->get();

            foreach ($repvit as $datorep) {
                $nuevoval = floatval($datorep->piezanueva) + floatval($datorep->valorajustado);
                $nvalresidual = $nuevoval * ($info->valresidual / 100);
                $newvaldepre = $nuevoval - round($nvalresidual, 2);
                $newdepreanual = $newvaldepre / $datorep->vidautil;
                $newvalbien = $info->valor + floatval($datorep->piezanueva) - floatval($datorep->piezasustituida);

                $datorep->dfechamodificacion = date("d-m-Y", strtotime($datorep->fecha));
                $datorep->dnuevovalor = "$" . number_format((float)$nuevoval, 2, '.', ',');
                $datorep->dpiezasustituida = "$" . number_format((float)$datorep->piezasustituida, 2, '.', ',');
                $datorep->dvalorresidual = "$" . number_format((float)$nvalresidual, 2, '.', ',');
                $datorep->dpiezanueva = "$" . number_format((float)$datorep->piezanueva, 2, '.', ',');
                $datorep->dvalordepreciar = "$" . number_format((float)$newvaldepre, 2, '.', ',');
                $datorep->dnuevovalorbien = "$" . number_format((float)$newvalbien, 2, '.', ',');
                $datorep->dvalorajustado = "$" . number_format((float)$datorep->valorajustado, 2, '.', ',');
            }

            /***************************************  CALCULOS GENERALES DE DEPRECIACION NORMAL  ****************************************/

            $aniocompra = date("Y", strtotime($info->fechacompra));

            if ($aniocompra == null) {
                return "Fecha de Compra es requerido";
            }

            $contador = round($aniospen) + 7;

            //por si la reposicion fue cuando ya se habia depreciado por completo el bien
            $vidaextra = SustitucionMueble::where('id_bienmueble', $info->id)->sum('vidautil');

            if ($vidaextra > 0) {
                $contador = $contador + floatval($vidaextra);
            }

            //---- CALCULO -----
            $numdias = $aniospen * 365;
            //dias del año UNO
            $fechafin = new DateTime($aniocompra . '-12-31');
            $interval2 = $fechafin->diff($fechacompra);
            $diasaniouno = $interval2->format('%a');

            //dias restantes / anios restantes
            $diasrestantes = $numdias - $diasaniouno;
            $aniosrestantes = $diasrestantes / 365;
            //depreciacion por dia
            $deppordia = number_format((float)($valordepre / $aniospen) / 365, 7, '.', ',');

            $i = 0;
            $depacumulada = 0;
            $depanualuno = $diasaniouno * $deppordia;

            $depanualfin = 0;

            $dataArray = array();

            while ($contador > 0) {
                $array["anio"] = $aniocompra;
                $fechaini = $array['anio'] . '-01-01';
                $fechafin = $array['anio'] . '-12-31';

                $valorbien = $info->valor;

                /******************************  CALCULO DE DEPRECIACION SI HAY REPOSICION VITAL ****************************/
                //SELECT * FROM sustitucion where bien = ? and fecha between ? and ?

                if ($repvitanio = SustitucionMueble::where('id_bienmueble', $info->id)
                    ->whereBetween('fecha', array($fechaini, $fechafin))
                    ->first()) {

                    $nuevoval = floatval($repvitanio->piezanueva) + floatval($repvitanio->valorajustado);
                    $nvalresidual = $nuevoval * ($info->valresidual / 100);
                    $newvaldepre = $nuevoval - round($nvalresidual, 2);
                    $newdepreanual = $newvaldepre / $repvitanio->vidautil;
                    $newvalbien = $info->valor + floatval($repvitanio->piezanueva) - floatval($repvitanio->piezasustituida);

                    //datos para calculos
                    $numdiasrep = floatval($repvitanio->vidautil) * 365;
                    $fechafin2 = new DateTime($fechafin);
                    $fecharep = new DateTime($repvitanio->fecha);
                    $interval22 = $fechafin2->diff($fecharep);
                    $diasaniounorep = $interval22->format('%a');

                    //dias de depreciacion antes de la reposicion
                    if ($depanualfin > 0) {
                        $diasantes = 365 - $diasaniounorep;
                        $depanterior = $diasantes * $deppordia;
                        $new2 = $valorbien - $depacumulada - $depanterior;

                        $dataArray[] = [
                            'aniocompra' => $aniocompra,
                            'depanterior' => number_format((float)$depanterior, 2, '.', ','),
                            'depacumulada' => number_format((float)$depacumulada + $depanterior, 2, '.', ','),
                            'new2' => number_format((float)$new2, 2, '.', ','),
                            'color' => 1, // gris
                        ];

                        $array["depanterior"] = $depanterior;
                    }

                    //dias restantes / anios restantes
                    $diasrestantes = $numdiasrep - $diasaniounorep;
                    $aniosrestantes = $diasrestantes / 365;

                    $contador = floatval($repvitanio->vidautil) + 1;
                    $deppordia = number_format(($newdepreanual) / 365, 7);
                    //reinicio datos
                    $depanualuno = $diasaniounorep * $deppordia;

                    $depacumulada = 0;
                    $i = 0;
                    $valorbien = round(floatval($nuevoval), 2);
                    $nuevovalporrep = $valorbien;

                    // Borrar historial de depreciacion de los años restantes
                    $aniob = intval($aniocompra);
                    $bandera = $contador + 1;
                    while ($bandera >= 0) {
                        // DELETE FROM historialda WHERE bien = ? and anio  = ?

                        HistorialdaMueble::where('id_bienmueble', $request->id)
                            ->where('anio', $aniob)->delete();

                        //$delhistorialda = $select->eliminarDAByanio($aniob, $array["bien"]);
                        $bandera--;
                        $aniob++;
                    }
                }

                // PARA EL CALCULO DE LA DEPRECIACION ANUAL DE LA TABLA
                if ($i == 0) {
                    $depanualfin = $depanualuno;
                } else {
                    if ($diasrestantes >= 365) {
                        $depanualfin = $deppordia * 365;
                        $diasrestantes = $diasrestantes - 365;
                    } else {
                        $depanualfin = $deppordia * $diasrestantes;
                        if ($depanualfin <= 0) {
                            $depanualfin = 0;
                        }
                        $diasrestantes = $diasrestantes - 365;
                    }
                }

                //si hay depreciacion anterior que sume las dos depreciaciones del mismo anio para guardarla asi en la db
                if (isset($array["depanterior"]) && $array["depanterior"] != 0) {
                    $array["depanual"] = $depanualfin + floatval($array["depanterior"]);
                } else {
                    $array["depanual"] = $depanualfin;
                }

                //GUARDAR DEPRECIACION ACUMULADA EN EL ARRAY TABLA
                if ($i == 0) {
                    $depacumulada += $depanualuno;
                } else {
                    if ($depanualfin <= 0) {
                        $depacumulada = 0;
                    }
                    $depacumulada += $depanualfin;
                }

                //$array["depacumulada"] = $depacumulada;

                // variable afuera para agregarlo al array
                $varNew2 = 0;

                //GUARDAR VALOR EN LIBROS EN EL ARREGLO Y TABLA
                if ($depanualfin <= 0) {
                    // varNew2 = 0;

                    //$pdf->Cell(4,0.5,'$ '.number_format(0,2,'.',','),0,0,'C',1);
                } else {
                    if ($i == 0) {
                        $new = $valorbien - $depanualfin;
                    } else {
                        if (isset($nuevovalporrep) && $nuevovalporrep != NULL) {
                            $new = floatval($nuevovalporrep) - $depacumulada;
                        } else {
                            $new = $valorbien - $depacumulada;
                        }
                    }
                    $varNew2 = $new;
                    //$pdf->Cell(4,0.5,'$ '.number_format($new,2,'.',','),0,0,'C',1);
                    $array["vallibros"] = $new;
                }

                //*** GUARDAR ARRAY

                $dataArray[] = [
                    'aniocompra' => $aniocompra,
                    'depanterior' => number_format((float)$depanualfin, 2, '.', ','),
                    'depacumulada' => number_format((float)$depacumulada, 2, '.', ','),
                    'new2' => number_format((float)$varNew2, 2, '.', ','),
                    'color' => 2, // sin color
                ];

                //GUARDAR LOS DATOS EN EL HISTORIAL DE DEPRECIACION ACUMULADA
                //SELECT * FROM historialda WHERE bien = '". $bien."' AND anio = '".$anio."' "

                if(!HistorialdaMueble::where('id_bienmueble', $request->id)->where('anio', $array['anio'])->first()){

                    // guardar
                    $savei = new HistorialdaMueble();
                    $savei->id_bienmueble = $request->id;
                    $savei->vallibros = $array['vallibros'];
                    $savei->depanual = $array['depanual'];
                    $savei->depacumulada = $depacumulada;
                    $savei->anio = $array['anio'];
                    $savei->save();
                }

                //if(!$select->getHistorialda($array['bien'], $array['anio'])){

                //INSERT INTO historialda(bien, vallibros, depanual, depacumulada, anio) VALUES (?, ?, ?, ?, ?)")
                //    $bienes->addhistorialda($array);
                // }
                //$pdf->Ln(0.7);
                $contador--;
                $aniocompra++;
                $i++;
                $array["depanterior"] = 0;
            }

            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }




}
