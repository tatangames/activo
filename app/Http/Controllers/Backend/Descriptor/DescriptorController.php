<?php

namespace App\Http\Controllers\Backend\Descriptor;

use App\Http\Controllers\Controller;
use App\Models\Descriptor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DescriptorController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('backend.admin.descriptor.vistadescriptor');
    }

    public function tablaDescriptor(){
        $lista = Descriptor::orderBy('descripcion')->get();
        return view('backend.admin.descriptor.tabla.tabladescriptor', compact('lista'));
    }

    public function nuevoDescriptor(Request $request){

        $regla = array(
            'codigo' => 'required',
            'descripcion' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}


        $dato = new Descriptor();
        $dato->codigodes = $request->codigo;
        $dato->descripcion = $request->descripcion;

        if($dato->save()){
            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }

    // informacion
    public function informacionDescriptor(Request $request){
        $regla = array(
            'id' => 'required',
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if($lista = Descriptor::where('id', $request->id)->first()){

            return ['success' => 1, 'descriptor' => $lista];
        }else{
            return ['success' => 2];
        }
    }

    // editar
    public function editarDescriptor(Request $request){

        $regla = array(
            'id' => 'required',
            'codigo' => 'required',
            'descripcion' => 'required'
        );

        $validar = Validator::make($request->all(), $regla);

        if ($validar->fails()){ return ['success' => 0];}

        if(Descriptor::where('id', $request->id)->first()){

            Descriptor::where('id', $request->id)->update([
                'codigodes' => $request->codigo,
                'descripcion' => $request->descripcion
            ]);

            return ['success' => 1];
        }else{
            return ['success' => 2];
        }
    }
}
