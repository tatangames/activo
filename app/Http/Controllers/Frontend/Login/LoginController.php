<?php

namespace App\Http\Controllers\Frontend\Login;

use App\Http\Controllers\Controller;
use App\Models\HistorialModificacion;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function __construct(){
        $this->middleware('guest', ['except' => ['logout']]);
    }

    public function index(){
        return view('frontend.login.login');
    }

    public function login(Request $request){

        $rules = array(
            'usuario' => 'required',
            'password' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        if ( $validator->fails()){
            return ['success' => 0];
        }

        // si ya habia iniciado sesion, redireccionar
        if (Auth::check()) {
            return ['success'=> 1, 'ruta'=> route('admin.panel')];
        }

        if($dato = Usuario::where('usuario', $request->usuario)->first()){
            if(Auth::attempt(['usuario' => $request->usuario, 'password' => $request->password])) {

                $fecha = Carbon::now('America/El_Salvador');

                // guardar ingreso
                $reg = new HistorialModificacion();
                $reg->id_usuario = $dato->id;
                $reg->detalle = "Ingreso al sistema";
                $reg->fecha = $fecha;
                $reg->save();

                return ['success'=> 1, 'ruta'=> route('admin.panel')];
            }else{
                return ['success' => 2]; // password incorrecta
            }
        }else{
            return ['success' => 3]; // usuario no encontrado
        }
    }

    public function logout(Request $request){
        Auth::logout();
        return redirect('/');
    }
}
