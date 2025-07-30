<?php

namespace ApplicationTest\Utils;

class TestUtils
{
    public static function placaAleatoria(): string
    {
        $letras = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $numeros = '0123456789';

        return
            substr(str_shuffle($letras), 0, 3) .
            substr(str_shuffle($numeros), 0, 1) .
            substr(str_shuffle($letras), 0, 1) .
            substr(str_shuffle($numeros), 0, 2);
    }

    public static function gerarNumerosAleatorios($quantidade, $min = 0, $max = 100)
    {
        $numeros = [];

        for ($i = 0; $i < $quantidade; $i++) {
            $numeros[] = rand($min, $max);
        }

        return implode('', $numeros);
    }
}
