<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DescargoMueble extends Model
{
    use HasFactory;
    protected $table = 'descargo_mueble';
    public $timestamps = false;
}
