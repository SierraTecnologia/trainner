<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Data\Treinamento\Tecnicas\Filosofia;

use Data\Treinamento\Tecnicas\Tecnicas;

class Filosofia extends Tecnicas
{


    public static function getDataClasses()
    {
        return [
            FailFast::class,
        ];
    }
}
