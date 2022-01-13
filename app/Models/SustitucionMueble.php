<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SustitucionMueble extends Model
{
    use HasFactory;
    protected $table = 'sustitucion_mueble';
    public $timestamps = false;
}
