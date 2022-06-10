<?php

namespace App\Helpers;

class CpfValidatorHelper
{
    /**
     * @param $cpf
     * @return bool
     */
    public static function validateCpf($cpf): bool
    {
        // Extract only numbers
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

        // Checks if all digits have been entered.
        if (strlen($cpf) != 11) return false;

        // Checks if a sequence of repeated digits was entered.
        if (preg_match('/(\d)\1{10}/', $cpf)) return false;

        // Calculates
        for ($i = 9; $i < 11; $i++) {
            for ($d = 0, $c = 0; $c < $i; $c++) {
                $d += $cpf[$c] * (($i + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf[$c] != $d) return false;
        }

        return true;
    }
}
