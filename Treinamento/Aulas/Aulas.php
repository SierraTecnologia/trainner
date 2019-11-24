<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Data\Treinamento\Aulas;

use Data\Treinamento\Treinamento;

class Aulas extends Treinamento
{


    public static function getDataClasses()
    {
        return [
            Culinaria::class,
        ];
    }
}
