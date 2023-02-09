<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
    use HasFactory;

    protected $fillable = [
        'documentable_id',
        'documentable_type',
        'nro_telefonico',
    ];

    /**
     * Get the parent documentable model (oficina or persona).
     */
    public function documentable()
    {
        return $this->morphTo();
    }
}
