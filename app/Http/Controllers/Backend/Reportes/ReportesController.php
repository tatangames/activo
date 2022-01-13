<?php

namespace App\Http\Controllers\Backend\Reportes;

use App\Http\Controllers\Controller;
use App\Models\BienesMuebles;
use App\Models\Departamento;
use App\Models\Descriptor;
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
        $date2 = Carbon::parse($ff)->addDays(1)->format('Y-m-d');

        $f1 = Carbon::parse($fi)->format('d-m-Y');
        $f2 = Carbon::parse($ff)->format('d-m-Y');

        if($valor == 1){

            $lista = BienesMuebles::whereBetween('fechacompra', array($date1, $date2))
                ->orderBy('fechacompra', 'ASC')
                ->get();

            foreach ($lista as $ll){

                $lista->fechacompra = date("d-m-Y", strtotime($ll->fechacompra));

                $institucion = Departamento::where('id', $ll->id_departamento)->pluck('nombre')->first();
                $ll->institucion = $institucion;
            }

            $view =  \View::make('backend.admin.reportes.comodato.pdfcomodatomueble', compact(['lista', 'f1', 'f2']))->render();
            $pdf = \App::make('dompdf.wrapper');
            $pdf->getDomPDF()->set_option("enable_php", true);
            $pdf->loadHTML($view)->setPaper('carta', 'portrait');

            return $pdf->stream();

        }
        else if($valor == 2){
            return "2";

        }
        else if($valor == 3){
            return "2";

        }else{

            return "2";
        }
    }

    public function indexDescargos(){
        return view('backend.admin.reportes.descargos.vistareportedescargo');
    }

    public function pdfDescargos($fi, $ff, $valor){
        $view =  \View::make('backend.admin.reportes.comodato.pdfdescargos', compact(['lista', 'nombre']))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('carta', 'portrait');

        return $pdf->stream();
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
        $view =  \View::make('backend.admin.reportes.donaciones.pdfdonaciones', compact(['lista', 'nombre']))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('carta', 'portrait');

        return $pdf->stream();
    }

    public function indexReevaluos(){
        return view('backend.admin.reportes.reevaluos.vistareportereevaluos');
    }

    public function pdfReevaluos($fi, $ff, $valor){
        $view =  \View::make('backend.admin.reportes.reevaluos.pdfreevaluos', compact(['lista', 'nombre']))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('carta', 'portrait');

        return $pdf->stream();
    }

    public function indexDescriptor(){
        $lista = Descriptor::orderBy('descripcion')->get();
        return view('backend.admin.reportes.descriptor.vistareportedescriptor', compact('lista'));
    }

    public function pdfDescriptor($valor){
        $view =  \View::make('backend.admin.reportes.descriptor.pdfdescriptor', compact(['lista', 'nombre']))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('carta', 'portrait');

        return $pdf->stream();
    }

    public function indexCodigo(){
        return view('backend.admin.reportes.codigos.vistareportecodigos');
    }

    public function pdfCodigo($fi, $ff){

        $view =  \View::make('backend.admin.reportes.codigos.pdfcodigo', compact(['lista', 'nombre']))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('carta', 'portrait');

        return $pdf->stream();
    }

    public function indexRepvital(){
        return view('backend.admin.reportes.repvital.pdfrepvital');
    }

    public function pdfRevital($fi, $ff, $valor){
        $view =  \View::make('backend.admin.reportes.reevaluos.pdfreevaluos', compact(['lista', 'nombre']))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadHTML($view)->setPaper('carta', 'portrait');

        return $pdf->stream();
    }


}
