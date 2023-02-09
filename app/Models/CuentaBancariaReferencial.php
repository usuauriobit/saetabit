<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaBancariaReferencial extends Model
{
    use HasFactory;
    protected $fillable = [
        'nro_cuenta',
        'descripcion_cuenta',
        'glosa',
    ];
}
