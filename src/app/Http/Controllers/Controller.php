<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Checks if informed cpf is valid.
     * Code adapted from: https://gist.github.com/rafael-neri/ab3e58803a08cb4def059fce4e3c0e40
     * Atuhor: Rafael Neri 
     *
     * @param  string  $cpf
     * @return bollean
     */
    public function validateCpf ($cpf) {
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

    /**
     * Checks if informed cpf is valid.
     * Code adapted from: https://gist.github.com/guisehn/3276302
     * Author: Guilherme Sehn
     *
     * @param  string  $cpf
     * @return bollean
     */
    public function validateCnpj($cnpj) {
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
