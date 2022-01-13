<?php

namespace App\Http\Controllers\Backend\Principal;

use App\Http\Controllers\Controller;
use App\Models\BienesInmuebles;
use App\Models\BienesVehiculo;
use App\Models\CodigoContable;
use App\Models\CodigoDepreciacion;
use App\Models\Departamento;
use App\Models\Descriptor;
use App\Models\Estados;
use Illuminate\Http\Request;

class PrincipalController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('backend.admin.principal.principalvista.vistaprincipal');
    }

    public function nuevoBienIndex(){
        return view('backend.admin.principal.nuevobien.vistanuevobien');
    }

    public function vistaAgregarRegistroMueble(){

        $departamento = Departamento::orderBy('nombre')->get();
        $codcontable = CodigoContable::orderBy('nombre')->get();
        $coddepreciacion = CodigoDepreciacion::orderBy('nombre')->get();
        $coddescriptor = Descriptor::orderBy('descripcion')->get();

        return view('backend.admin.principal.nuevobien.ingresobienesmuebles', compact('departamento',
            'codcontable', 'coddepreciacion', 'coddescriptor'));
    }

    public function vistaAgregarRegistroVehiculo(){

        $departamento = Departamento::orderBy('nombre')->get();
        $codcontable = CodigoContable::orderBy('nombre')->get();
        $coddepreciacion = CodigoDepreciacion::orderBy('nombre')->get();

        $codigo = BienesVehiculo::max('codigo');
        if($codigo == null){
            $codigo = 1;
        }else{
            $codigo = $codigo + 1;
        }

        return view('backend.admin.principal.nuevobien.ingresovehiculo', compact('departamento',
            'codcontable', 'coddepreciacion', 'codigo'));
    }

    public function vistaAgregarRegistroInmueble(){
        $codigo = BienesInmuebles::max('codigo');
        if($codigo == null){
            $codigo = 1;
        }else{
            $codigo = $codigo + 1;
        }

        $estados = Estados::orderBy('nombre')->get();

        return view('backend.admin.principal.nuevobien.ingresobienesinmuebles', compact('codigo',
            'estados'));
    }

}
