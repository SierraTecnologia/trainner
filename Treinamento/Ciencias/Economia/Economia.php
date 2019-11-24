<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Data\Treinamento\Ciencias\Economia;

use Data\Treinamento\Ciencias\Ciencias;

class Economia extends Ciencias
{


    public static function getDataClasses()
    {
        return [
            FailFast::class,
        ];
    }
}
