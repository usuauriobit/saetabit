<?php

namespace App\Rules\Caja;

use App\Models\Pasaje;
use Illuminate\Contracts\Validation\Rule;

class TipoVueloMovimiento implements Rule
{
    public $documentable_id;
    public $documentable_type;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($documentable_id = null, $documentable_type = null)
    {
        $this->documentable_id = $documentable_id;
        $this->documentable_type = $documentable_type;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ($this->documentable_id != null & $this->documentable_type != null) {
            $venta = $this->documentable_type::find($this->documentable_id);
            if ($venta->detalle[0]->documentable_type == Pasaje::class) {
                if($venta->detalle[0]->documentable->vuelos[0]->tipo_vuelo->descripcion == 'Subvencionado') {
                    return $value == 2;
                }
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El tipo de comprobante seleccionado no corresponde al tipo de pasaje de la venta.';
    }
}
