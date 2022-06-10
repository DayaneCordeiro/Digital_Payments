<?php

namespace App\Helpers;

class CnpjValidatorHelper
{
    /**
     * @param $cnpj
     * @return bool
     */
    public static function validateCnpj($cnpj) {
        // Extract only numbers
        $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

        // Checks if all digits have been entered.
        if (strlen($cnpj) != 14) return false;

        // Checks if a sequence of repeated digits was entered.
        if (preg_match('/(\d)\1{13}/', $cnpj)) return false;

        // Validate first check digit
        for ($i = 0, $j = 5, $sum = 0; $i < 12; $i++) {
            $sum += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $rest = $sum % 11;

        if ($cnpj[12] != ($rest < 2 ? 0 : 11 - $rest)) return false;

        // Validate second check digit
        for ($i = 0, $j = 6, $sum = 0; $i < 13; $i++) {
            $sum += $cnpj[$i] * $j;
            $j = ($j == 2) ? 9 : $j - 1;
        }

        $rest = $sum % 11;

        return $cnpj[13] == ($rest < 2 ? 0 : 11 - $rest);
    }
}
