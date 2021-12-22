<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BienesInmuebles extends Model
{
    use HasFactory;
    protected $table = 'bienes_inmuebles';
    public $timestamps = false;
}
