<?php

namespace App\Http\Controllers\Backend\CodConta;

use App\Http\Controllers\Controller;
use App\Models\CodigoContable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CodigoContableController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('backend.admin.contable.vistacontable');
    }

    public function tablaContable(){
        $lista = CodigoContable::orderBy('nombre')->get();
        return view('backend.admin.contable.tabla.tablacontable', compact('lista'));
    }

    public function nuevoCodContable(Request $request){

        $regla = array(
            'codigo' => 'required',
            'nombre' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        $dato = new CodigoContable();
        $dato->codconta = $request->codigo;
        $dato->nombre = $request->nombre;

        if($dato->save()){
            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }

    // informacion
    public function informacionContable(Request $request){
        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if($lista = CodigoContable::where('id', $request->id)->first()){

            return ['success' => 1, 'contable' => $lista];
        }else{
            return ['success' => 2];
        }
    }

    // editar
    public function editarContable(Request $request){

        $regla = array(
            'id' => 'required',
            'codigo' => 'required',
            'nombre' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if(CodigoContable::where('id', $request->id)->first()){

            CodigoContable::where('id', $request->id)->update([
                'codconta' => $request->codigo,
                'nombre' => $request->nombre
            ]);

            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }
}
