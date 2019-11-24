<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Data\Treinamento\Artigos;

use Data\Treinamento\Treinamento;

class Artigos extends Treinamento
{


    public static function getDataClasses()
    {
        return array_merge(
            Empreendedorismo\Empreendedorismo::getDataClasses(),
            Filosofia\Filosofia::getDataClasses(),
        );
    }
}
