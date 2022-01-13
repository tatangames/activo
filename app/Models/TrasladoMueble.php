<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrasladoMueble extends Model
{
    use HasFactory;
    protected $table = 'traslado_muebles';
    public $timestamps = false;
}
