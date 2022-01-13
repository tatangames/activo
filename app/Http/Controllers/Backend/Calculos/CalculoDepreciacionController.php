<?php

namespace App\Http\Controllers\Backend\Calculos;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use Illuminate\Http\Request;

class CalculoDepreciacionController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('backend.admin.calculos.depreciacion.vistadepreciacion');
    }

    public function pdfAnual(){
        $lista = Departamento::orderBy('id', 'ASC')->get();

        $view =  \View::make('backend.admin.calculos.reporte.pdfanual', compact(['lista']))->render();
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('carta', 'portrait');

        return $pdf->stream();
    }

    public function pdfCodigo(){
        return "codigo";
    }

}
