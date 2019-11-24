<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Data\Treinamento\Tecnicas\Empreendedorismo;

use Data\Treinamento\Tecnicas\Tecnicas;

class Empreendedorismo extends Tecnicas
{


    public static function getDataClasses()
    {
        return [
            FailFast::class,
        ];
    }
}
