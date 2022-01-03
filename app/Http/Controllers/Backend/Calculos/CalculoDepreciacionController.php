<?php

namespace App\Http\Controllers\Backend\Calculos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CalculoDepreciacionController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('backend.admin.calculos.depreciacion.vistadepreciacion');
    }




}
