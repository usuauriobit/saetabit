<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPasaje extends Model
{
    use HasFactory;

    protected $fillable = [
        'abreviatura',
        'descripcion',
        'edad_minima',
        'edad_maxima',
        'ocupa_asiento',
    ];
    public function getAbreviaturaDescAttribute(){
        return "{$this->abreviatura} - {$this->descripcion}";
    }
}
