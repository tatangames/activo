<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodigoContable extends Model
{
    use HasFactory;
    protected $table = 'codigo_contable';
    public $timestamps = false;
}
