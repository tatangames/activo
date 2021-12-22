<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BienesVehiculo extends Model
{
    use HasFactory;
    protected $table = 'bienes_vehiculo';
    public $timestamps = false;
}
