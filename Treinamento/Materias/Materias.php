<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Data\Treinamento\Materias;

use Data\Treinamento\Treinamento;

class Materias extends Treinamento
{


    public static function getDataClasses()
    {
        return array_merge(
            Empreendedorismo\Empreendedorismo::getDataClasses(),
            Filosofia\Filosofia::getDataClasses(),
        );
    }
}
