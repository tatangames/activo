<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Descriptor extends Model
{
    use HasFactory;
    protected $table = 'descriptor';
    public $timestamps = false;
}
