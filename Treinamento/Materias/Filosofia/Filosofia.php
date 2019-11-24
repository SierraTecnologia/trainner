<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Data\Treinamento\Materias\Filosofia;

use Data\Treinamento\Materias\Materias;

class Filosofia extends Materias
{


    public static function getDataClasses()
    {
        return [
            FailFast::class,
        ];
    }
}
