<?php

namespace App\Http\Controllers\Backend\CodDepre;

use App\Http\Controllers\Controller;
use App\Models\CodigoDepreciacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CodigoDepreciacionController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('backend.admin.despreciacion.vistadespreciacion');
    }

    public function tablaDepreciacion(){
        $lista = CodigoDepreciacion::orderBy('nombre')->get();
        return view('backend.admin.despreciacion.tabla.tabladespreciacion', compact('lista'));
    }

    public function nuevoCodDepreciacion(Request $request){

        $regla = array(
            'codigo' => 'required',
            'descripcion' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}


        $dato = new CodigoDepreciacion();
        $dato->coddepre = $request->codigo;
        $dato->nombre = $request->descripcion;

        if($dato->save()){
            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }

    // informacion
    public function informacionDepreciacion(Request $request){
        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if($lista = CodigoDepreciacion::where('id', $request->id)->first()){

            return ['success' => 1, 'depreciacion' => $lista];
        }else{
            return ['success' => 2];
        }
    }

    // editar
    public function editarDepreciacion(Request $request){

        $regla = array(
            'id' => 'required',
            'codigo' => 'required',
            'descripcion' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if(CodigoDepreciacion::where('id', $request->id)->first()){

            CodigoDepreciacion::where('id', $request->id)->update([
                'coddepre' => $request->codigo,
                'nombre' => $request->descripcion
            ]);

            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }
}
