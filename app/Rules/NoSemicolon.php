<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NoSemicolon implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Vérifie si le texte ne contient pas de point-virgule
        return !strpos($value, ';');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Le :attribute ne doit pas contenir de points-virgules.';
    }
}
