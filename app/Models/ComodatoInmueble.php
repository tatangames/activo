<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComodatoInmueble extends Model
{
    use HasFactory;
    protected $table = 'comodato_inmueble';
    public $timestamps = false;
}
