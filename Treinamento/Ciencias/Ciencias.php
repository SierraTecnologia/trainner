<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Data\Treinamento\Ciencias;

use Data\Treinamento\Treinamento;

class Ciencias extends Treinamento
{


    public static function getDataClasses()
    {
        return array_merge(
            Economia\Economia::getDataClasses(),
            Filosofia\Filosofia::getDataClasses(),
        );
    }
}
