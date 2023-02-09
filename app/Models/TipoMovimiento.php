<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMovimiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'descripcion'
    ];
    public function getIsIngresoAttribute(){
        return (bool) $this->descripcion === 'Ingreso';
    }
}
