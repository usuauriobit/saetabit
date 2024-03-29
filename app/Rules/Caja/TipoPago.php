<?php

namespace App\Rules\Caja;

use App\Models\TipoPago as ModelsTipoPago;
use Illuminate\Contracts\Validation\Rule;

class TipoPago implements Rule
{
    public $form;
    public $tipo_pago;
    public $cuenta_cobrar;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($form, $cuenta_cobrar = null)
    {
        $this->form = $form;
        $this->tipo_pago = ModelsTipoPago::find($form['tipo_pago_id'] ?? null);
        $this->cuenta_cobrar = $cuenta_cobrar;
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
        if ($this->tipo_pago->descripcion == 'Crédito' && $this->cuenta_cobrar !== null) {
            if (array_key_exists('cuotas', $this->form)) {
                return (count($this->form['cuotas']) > 0 & collect($this->form['cuotas'])->sum('importe') == $this->cuenta_cobrar->importe);
            }
            return false;
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
        return 'Los datos ingresados no son correctos para el tipo de pago seleccionado.';
    }
}
