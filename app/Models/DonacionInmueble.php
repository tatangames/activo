<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonacionInmueble extends Model
{
    use HasFactory;
    protected $table = 'donacion_inmueble';
    public $timestamps = false;
}
