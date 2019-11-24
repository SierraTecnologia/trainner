<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Data\Treinamento\Ciencias\Filosofia;

use Data\Treinamento\Ciencias\Ciencias;

class Filosofia extends Ciencias
{


    public static function getDataClasses()
    {
        return [
            FailFast::class,
        ];
    }
}
