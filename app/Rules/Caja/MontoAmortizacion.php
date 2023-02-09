<?php

namespace App\Rules\Caja;

use Illuminate\Contracts\Validation\Rule;

class MontoAmortizacion implements Rule
{
    public $cuenta_cobrar;
    public $class;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($cuenta_cobrar)
    {
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
        // $model = $this->class::find($this->model_id);
        return $this->cuenta_cobrar->saldo >= $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El monto a pagar es mayor al monto pendiente.';
    }
}
