<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonacionMueble extends Model
{
    use HasFactory;
    protected $table = 'donacion_mueble';
    public $timestamps = false;
}
