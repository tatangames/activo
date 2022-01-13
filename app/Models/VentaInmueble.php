<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaInmueble extends Model
{
    use HasFactory;
    protected $table = 'venta_inmueble';
    public $timestamps = false;
}
