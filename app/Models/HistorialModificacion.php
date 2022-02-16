<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialModificacion extends Model
{
    use HasFactory;
    protected $table = 'historial_modificacion';
    public $timestamps = false;
}
