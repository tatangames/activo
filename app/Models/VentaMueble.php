<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaMueble extends Model
{
    use HasFactory;
    protected $table = 'venta_mueble';
    public $timestamps = false;
}
