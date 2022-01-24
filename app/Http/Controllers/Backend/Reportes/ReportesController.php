<?php

namespace App\Http\Controllers\Backend\Reportes;

use App\Http\Controllers\Controller;
use App\Models\BienesInmuebles;
use App\Models\BienesMuebles;
use App\Models\BienesVehiculo;
use App\Models\CodigoContable;
use App\Models\ComodatoInmueble;
use App\Models\ComodatoMaquinaria;
use App\Models\ComodatoMueble;
use App\Models\Departamento;
use App\Models\DescargoMaquinaria;
use App\Models\DescargoMueble;
use App\Models\Descriptor;
use App\Models\DonacionInmueble;
use App\Models\DonacionMaquinaria;
use App\Models\DonacionMueble;
use App\Models\ReevaluoInmueble;
use App\Models\SustitucionMaquinaria;
use App\Models\SustitucionMueble;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportesController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function indexDepartamento(){

        $departamento = Departamento::orderBy('nombre')->get();

        return view('backend.admin.reportes.departamento.vistareportedepartamento', compact('departamento'));
    }

    public function pdfDepartamento($id){

        $nombre = Departamento::where('id', $id)->pluck('nombre')->first();

        $lista = BienesMuebles::where('id_departamento', $id)->orderBy('id', 'ASC')->get();

        foreach ($lista as $ll){
            $lista->fechacompra = date("d-m-Y", strtotime($ll->fechacompra));

            $infoDepartamento = Departamento::where('id', $ll->id_departamento)->first();
            $infoDescriptor = Descriptor::where('id', $ll->id_descriptor)->first();

            $codigo = $infoDepartamento->codigo . '-' . $infoDescriptor->codigodes . '-' . $ll->correlativo;

            $ll->codigo = $codigo;

            if($ll->valor != null){
                $ll->valor = "$" . $ll->valor;
            }
        }

        $view =  \View::make('backend.admin.reportes.departamento.pdfdepartamento', compact(['lista', 'nombre']))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('carta', 'portrait');

        return $pdf->stream();
    }

    public function indexInventario(){
        return view('backend.admin.reportes.inventario.vistareporteinventario');
    }

    // reporte muebles
    public function pdfInventarioMuebles($valor){
        // 1: mayor a 600, 2: menor a 600, 3: ver todos

        if($valor == 1){
            return "1";
        }
        else if($valor == 2){
            return "2";
        }
        else if($valor == 3){
            return "3";
        }else{
            return "0";
        }
    }

    // reporte muebles
    public function pdfInventarioInmuebles(){

    }

    // reporte maquinaria
    public function pdfInventarioMaquinaria(){

    }

    // reporte bienes
    public function pdfInventarioBienes($valor){
        // 1: bienes muebles, 2: bienes inmuebles, 3: maquinaria y equipo

        if($valor == 1){
            return "1";
        }
        else if($valor == 2){
            return "2";
        }
        else if($valor == 3){
            return "3";
        }else{
            return "0";
        }
    }

    public function indexComodato(){
        return view('backend.admin.reportes.comodato.vistareportecomodato');
    }

    public function pdfComodato($fi, $ff, $valor){

        // valor
        // 1: mueble
        // 2: inmueble
        // 3: maquinaria

        $date1 = Carbon::parse($fi)->format('Y-m-d');
        $date2 = Carbon::parse($ff)->format('Y-m-d');

        $f1 = Carbon::parse($fi)->format('d-m-Y');
        $f2 = Carbon::parse($ff)->format('d-m-Y');

        if($valor == 1){

            $lista = ComodatoMueble::whereBetween('fecha', array($date1, $date2))
                ->orderBy('fecha', 'ASC')
                ->get();

            $haydatos = false;

            foreach ($lista as $ll){
                $haydatos = true;

                if($ll->fechacompra != null) {
                    $ll->fechacompra = date("d-m-Y", strtotime($ll->fechacompra));
                }

                $datos = BienesMuebles::where('id', $ll->id_bienmueble)->first();

                $ll->descripcion = $datos->descripcion;
                $ll->codigo = $datos->codigo;
                if($datos->valor != null){
                    $ll->valor = '$' . number_format((float)$datos->valor, 2, '.', ',');
                }else{
                    $ll->valor = '';
                }
            }

            $view =  \View::make('backend.admin.reportes.comodato.pdfcomodatomueble', compact(['lista', 'haydatos', 'f1', 'f2']))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadHTML($view)->setPaper('carta', 'portrait');

            return $pdf->stream();
        }
        else if($valor == 2){
            $lista = ComodatoInmueble::whereBetween('fecha', array($date1, $date2))
                ->orderBy('fecha', 'ASC')
                ->get();

            $haydatos = false;

            foreach ($lista as $ll){
                $haydatos = true;

                if($ll->fechacompra != null) {
                    $ll->fechacompra = date("d-m-Y", strtotime($ll->fechacompra));
                }

                $datos = BienesInmuebles::where('id', $ll->id_bieninmueble)->first();

                $ll->descripcion = $datos->descripcion;
                $ll->codigo = $datos->codigo;
                if($datos->valor != null){
                    $ll->valor = '$' . number_format((float)$datos->valor, 2, '.', ',');
                }else{
                    $ll->valor = '';
                }
            }

            $view =  \View::make('backend.admin.reportes.comodato.pdfcomodatoinmueble', compact(['lista', 'haydatos', 'f1', 'f2']))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadHTML($view)->setPaper('carta', 'portrait');

            return $pdf->stream();
        }
        else if($valor == 3){
            $lista = ComodatoMaquinaria::whereBetween('fecha', array($date1, $date2))
                ->orderBy('fecha', 'ASC')
                ->get();

            $haydatos = false;

            foreach ($lista as $ll){
                $haydatos = true;

                if($ll->fechacompra != null) {
                    $ll->fechacompra = date("d-m-Y", strtotime($ll->fechacompra));
                }

                $datos = BienesVehiculo::where('id', $ll->id_bienvehiculo)->first();

                $ll->descripcion = $datos->descripcion;
                $ll->codigo = $datos->codigo;
                if($datos->valor != null){
                    $ll->valor = '$' . number_format((float)$datos->valor, 2, '.', ',');
                }else{
                    $ll->valor = '';
                }
            }

            $view =  \View::make('backend.admin.reportes.comodato.pdfcomodatomaquinaria', compact(['lista', 'haydatos', 'f1', 'f2']))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadHTML($view)->setPaper('carta', 'portrait');

            return $pdf->stream();
        }else{
            return "0";
        }
    }

    public function indexDescargos(){
        return view('backend.admin.reportes.descargos.vistareportedescargo');
    }

    public function pdfDescargos($fi, $ff, $valor){

        // valor
        // 1: mueble
        // 2: maquinaria

        $date1 = Carbon::parse($fi)->format('Y-m-d');
        $date2 = Carbon::parse($ff)->format('Y-m-d');

        $f1 = Carbon::parse($fi)->format('d-m-Y');
        $f2 = Carbon::parse($ff)->format('d-m-Y');

        if($valor == 1){

            $lista = DescargoMueble::whereBetween('fecha', array($date1, $date2))
                ->orderBy('fecha', 'ASC')
                ->get();

            $haydatos = false;

            foreach ($lista as $ll){
                $haydatos = true;
                if($ll->fecha != null) {
                    $ll->fecha = date("d-m-Y", strtotime($ll->fecha));
                }

                $datos = BienesMuebles::where('id', $ll->id_bienmueble)->first();

                $ll->descripcion = $datos->descripcion;
                $ll->codigo = $datos->codigo;
                if($datos->valor != null){
                    $ll->valor = '$' . number_format((float)$datos->valor, 2, '.', ',');
                }else{
                    $ll->valor = '';
                }
            }

            $view =  \View::make('backend.admin.reportes.descargos.pdfdescargomueble', compact(['lista', 'haydatos', 'f1', 'f2']))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadHTML($view)->setPaper('carta', 'portrait');

            return $pdf->stream();
        }
        else if($valor == 2){
            $lista = DescargoMaquinaria::whereBetween('fecha', array($date1, $date2))
                ->orderBy('fecha', 'ASC')
                ->get();

            $haydatos = false;

            foreach ($lista as $ll){
                $haydatos = true;

                if($ll->fecha != null) {
                    $ll->fecha = date("d-m-Y", strtotime($ll->fecha));
                }

                $datos = BienesVehiculo::where('id', $ll->id_bienvehiculo)->first();

                $ll->descripcion = $datos->descripcion;
                $ll->codigo = $datos->codigo;
                if($datos->valor != null){
                    $ll->valor = '$' . number_format((float)$datos->valor, 2, '.', ',');
                }else{
                    $ll->valor = '';
                }
            }

            $view =  \View::make('backend.admin.reportes.descargos.pdfdescargomaquinaria', compact(['lista', 'haydatos', 'f1', 'f2']))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadHTML($view)->setPaper('carta', 'portrait');

            return $pdf->stream();
        }else{
            return "0";
        }
    }

    public function indexVentas(){
        return view('backend.admin.reportes.ventas.vistareporteventas');
    }

    public function pdfVentas($fi, $ff, $valor){
        $view =  \View::make('backend.admin.reportes.ventas.pdfventas', compact(['lista', 'nombre']))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('carta', 'portrait');

        return $pdf->stream();
    }

    public function indexDonaciones(){
        return view('backend.admin.reportes.donaciones.vistareportedonaciones');
    }

    public function pdfDonaciones($fi, $ff, $valor){

        // valor
        // 1: mueble
        // 2: inmueble
        // 3: maquinaria

        $date1 = Carbon::parse($fi)->format('Y-m-d');
        $date2 = Carbon::parse($ff)->format('Y-m-d');

        $f1 = Carbon::parse($fi)->format('d-m-Y');
        $f2 = Carbon::parse($ff)->format('d-m-Y');

        if($valor == 1){

            $lista = DonacionMueble::whereBetween('fecha', array($date1, $date2))
                ->orderBy('fecha', 'ASC')
                ->get();

            $haydatos = false;

            foreach ($lista as $ll){
                $haydatos = true;

                if($ll->fecha != null) {
                    $ll->fecha = date("d-m-Y", strtotime($ll->fecha));
                }

                $datos = BienesMuebles::where('id', $ll->id_bienmueble)->first();

                $ll->descripcion = $datos->descripcion;
                $ll->codigo = $datos->codigo;
                if($datos->valor != null){
                    $ll->valor = '$' . number_format((float)$datos->valor, 2, '.', ',');
                }else{
                    $ll->valor = '';
                }
            }

            $view =  \View::make('backend.admin.reportes.donaciones.pdfdonacionmueble', compact(['lista', 'haydatos', 'f1', 'f2']))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadHTML($view)->setPaper('carta', 'portrait');

            return $pdf->stream();
        }
        else if($valor == 2){
            $lista = DonacionInmueble::whereBetween('fecha', array($date1, $date2))
                ->orderBy('fecha', 'ASC')
                ->get();

            $haydatos = false;

            foreach ($lista as $ll){
                $haydatos = true;

                if($ll->fecha != null) {
                    $ll->fecha = date("d-m-Y", strtotime($ll->fecha));
                }

                $datos = BienesInmuebles::where('id', $ll->id_bieninmueble)->first();

                $ll->descripcion = $datos->descripcion;
                $ll->codigo = $datos->codigo;
                if($datos->valor != null){
                    $ll->valor = '$' . number_format((float)$datos->valor, 2, '.', ',');
                }else{
                    $ll->valor = '';
                }
            }

            $view =  \View::make('backend.admin.reportes.donaciones.pdfdonacioninmueble', compact(['lista', 'haydatos', 'f1', 'f2']))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadHTML($view)->setPaper('carta', 'portrait');

            return $pdf->stream();
        }
        else if($valor == 3){
            $lista = DonacionMaquinaria::whereBetween('fecha', array($date1, $date2))
                ->orderBy('fecha', 'ASC')
                ->get();

            $haydatos = false;

            foreach ($lista as $ll){
                $haydatos = true;

                if($ll->fecha != null) {
                    $ll->fecha = date("d-m-Y", strtotime($ll->fecha));
                }

                $datos = BienesVehiculo::where('id', $ll->id_bienvehiculo)->first();

                $ll->descripcion = $datos->descripcion;
                $ll->codigo = $datos->codigo;
                if($datos->valor != null){
                    $ll->valor = '$' . number_format((float)$datos->valor, 2, '.', ',');
                }else{
                    $ll->valor = '';
                }
            }

            $view =  \View::make('backend.admin.reportes.donaciones.pdfdonacionmaquinaria', compact(['lista', 'haydatos', 'f1', 'f2']))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadHTML($view)->setPaper('carta', 'portrait');

            return $pdf->stream();
        }else{
            return "0";
        }
    }

    public function indexReevaluos(){
        return view('backend.admin.reportes.reevaluos.vistareportereevaluos');
    }

    // unicamente inmuebles
    public function pdfReevaluos($fi, $ff){

        $date1 = Carbon::parse($fi)->format('Y-m-d');
        $date2 = Carbon::parse($ff)->format('Y-m-d');

        $f1 = Carbon::parse($fi)->format('d-m-Y');
        $f2 = Carbon::parse($ff)->format('d-m-Y');

        $lista = ReevaluoInmueble::whereBetween('fecha', array($date1, $date2))
            ->orderBy('fecha', 'ASC')
            ->get();

        $haydatos = false;

        foreach ($lista as $ll){
            $haydatos = true;

            if($ll->fecha != null) {
                $ll->fecha = date("d-m-Y", strtotime($ll->fecha));
            }

            $datos = BienesInmuebles::where('id', $ll->id_bieninmueble)->first();

            $ll->descripcion = $datos->descripcion;
            $ll->codigo = $datos->codigo;
            if($datos->valor != null){
                $ll->valor = '$' . number_format((float)$datos->valor, 2, '.', ',');
            }else{
                $ll->valor = '';
            }

            if($ll->valornuevo != null){
                $ll->valornuevo = '$' . number_format((float)$ll->valornuevo, 2, '.', ',');
            }else{
                $ll->valornuevo = '';
            }
        }

        $view =  \View::make('backend.admin.reportes.reevaluos.pdfreevaluoinmueble', compact(['lista', 'haydatos', 'f1', 'f2']))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('carta', 'portrait');

        return $pdf->stream();
    }

    public function indexDescriptor(){
        $lista = Descriptor::orderBy('descripcion')->get();
        return view('backend.admin.reportes.descriptor.vistareportedescriptor', compact('lista'));
    }

    public function pdfDescriptor($id){
        $lista = BienesMuebles::where('id_descriptor', $id)
            ->orderBy('fechacompra', 'ASC')
            ->get();

        $infodes = Descriptor::where('id', $id)->first();
        $nombre = $infodes->descripcion;

        $haydatos = false;

        $total = 0;
        foreach ($lista as $ll){
            $haydatos = true;
            $total = $total + 1;

            if($ll->fechacompra != null) {
                $ll->fechacompra = date("d-m-Y", strtotime($ll->fechacompra));
            }

            if($ll->valor != null){
                $ll->valor = '$' . number_format((float)$ll->valor, 2, '.', ',');
            }else{
                $ll->valor = '';
            }
        }

        $view =  \View::make('backend.admin.reportes.descriptor.pdfdescriptor', compact(['lista', 'total', 'haydatos', 'nombre']))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('carta', 'portrait');

        return $pdf->stream();
    }

    public function indexCodigo(){
        return view('backend.admin.reportes.codigos.vistareportecodigos');
    }

    public function pdfCodigo($fi, $ff){

        $f1 = Carbon::parse($fi)->format('d-m-Y');
        $f2 = Carbon::parse($ff)->format('d-m-Y');

        $listado = CodigoContable::orderBy('codconta', 'ASC')->get();

        $resultsBloque = array();
        $index = 0;

        foreach($listado as $secciones){
            array_push($resultsBloque,$secciones);

            $subSecciones = BienesMuebles::where('id_codcontable', $secciones->id)
                ->where('id_codcontable', '!=', null)
                ->where('valor', '>', 600)
                ->orderBy('fechacompra', 'ASC')
                ->get();

            $total = 0;
            foreach ($subSecciones as $ss){
                if($ss->valor != null){
                    $total = $total + $ss->valor;
                }

                if($ss->fechacompra != null) {
                    $ss->fechacompra = date("d-m-Y", strtotime($ss->fechacompra));
                }
            }

            $total = number_format((float)$total, 2, '.', ',');
            $secciones->total = $total;

            $resultsBloque[$index]->extra = $subSecciones;
            $index++;
        }

        $view =  \View::make('backend.admin.reportes.codigos.pdfcodigo', compact(['listado', 'f1', 'f2']))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('carta', 'landscape');

        return $pdf->stream();
    }

    public function indexRepvital(){
        return view('backend.admin.reportes.repvital.vistareporterepvital');
    }

    public function pdfRevital($fi, $ff, $valor){

        // valor
        // 1: mueble
        // 2: maquinaria

        $date1 = Carbon::parse($fi)->format('Y-m-d');
        $date2 = Carbon::parse($ff)->format('Y-m-d');

        $f1 = Carbon::parse($fi)->format('d-m-Y');
        $f2 = Carbon::parse($ff)->format('d-m-Y');

        if($valor == 1){

            $lista = SustitucionMueble::whereBetween('fecha', array($date1, $date2))
                ->orderBy('fecha', 'ASC')
                ->get();

            $haydatos = false;

            foreach ($lista as $ll){
                $haydatos = true;

                if($ll->fecha != null) {
                    $ll->fecha = date("d-m-Y", strtotime($ll->fecha));
                }

                $datos = BienesMuebles::where('id', $ll->id_bienmueble)->first();

                $ll->descripcion = $datos->descripcion;
                $ll->codigo = $datos->codigo;
                if($datos->valor != null){
                    $ll->valor = '$' . number_format((float)$datos->valor, 2, '.', ',');
                }else{
                    $ll->valor = '';
                }
            }

            $view =  \View::make('backend.admin.reportes.repvital.pdfrepvitalmueble', compact(['lista', 'haydatos', 'f1', 'f2']))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadHTML($view)->setPaper('carta', 'portrait');

            return $pdf->stream();
        }
        else if($valor == 2){
            $lista = SustitucionMaquinaria::whereBetween('fecha', array($date1, $date2))
                ->orderBy('fecha', 'ASC')
                ->get();

            $haydatos = false;

            foreach ($lista as $ll){
                $haydatos = true;

                if($ll->fecha != null) {
                    $ll->fecha = date("d-m-Y", strtotime($ll->fecha));
                }

                $datos = BienesVehiculo::where('id', $ll->id_bienvehiculo)->first();

                $ll->descripcion = $datos->descripcion;
                $ll->codigo = $datos->codigo;
                if($datos->valor != null){
                    $ll->valor = '$' . number_format((float)$datos->valor, 2, '.', ',');
                }else{
                    $ll->valor = '';
                }
            }

            $view =  \View::make('backend.admin.reportes.repvital.pdfrepvitalmaquinaria', compact(['lista', 'haydatos', 'f1', 'f2']))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadHTML($view)->setPaper('carta', 'portrait');

            return $pdf->stream();
        }
        else{
            return "0";
        }

    }


}
