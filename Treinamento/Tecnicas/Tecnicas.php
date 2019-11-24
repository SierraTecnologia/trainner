<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Data\Treinamento\Tecnicas;

use Data\Treinamento\Treinamento;

class Tecnicas extends Treinamento
{


    public static function getDataClasses()
    {
        return array_merge(
            Empreendedorismo\Empreendedorismo::getDataClasses(),
            Filosofia\Filosofia::getDataClasses(),
            Hacker\Hacker::getDataClasses(),
        );
    }
}
