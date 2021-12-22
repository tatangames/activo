<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BienesMuebles extends Model
{
    use HasFactory;
    protected $table = 'bienes_muebles';
    public $timestamps = false;
}
