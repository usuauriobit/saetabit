<?php

namespace App\Rules\Caja;

use App\Models\CajaAperturaCierre;
use App\Models\DenominacionBillete;
use Illuminate\Contracts\Validation\Rule;

class MontoCierreCaja implements Rule
{
    public $apertura_cierre_id;
    public $apertura_cierre = null;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($apertura_cierre_id)
    {
        $this->apertura_cierre = CajaAperturaCierre::find($apertura_cierre_id);
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
        $total = 0;

        foreach ($value as $key => $cantidad) {
            $denominacion =  DenominacionBillete::find($key);
            $total += (double) $denominacion->valor * (double) $cantidad;
        }

        // dd($this->apertura_cierre->total_efectivo, $total);
        // dd($this->apertura_cierre->total_efectivo == $total);

        return (double) $this->apertura_cierre->total_efectivo == (double) $total;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Los montos para el cierre no coiciden.';
    }
}
