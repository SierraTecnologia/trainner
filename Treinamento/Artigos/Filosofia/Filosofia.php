<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Data\Treinamento\Artigos\Filosofia;

use Data\Treinamento\Artigos\Artigos;

class Filosofia extends Artigos
{


    public static function getDataClasses()
    {
        return [
            Ti::class,
        ];
    }
}
