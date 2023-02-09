<?php

namespace App\Rules\Caja;

use App\Models\Venta;
use Illuminate\Contracts\Validation\Rule;

class MontoMovimiento implements Rule
{
    public $venta_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($venta_id)
    {
        $this->venta_id = $venta_id;
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
        $venta = Venta::find($this->venta_id);
        return $venta->saldo_por_ingresar >= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El importe ingresado supera el importe disponible.';
    }
}
