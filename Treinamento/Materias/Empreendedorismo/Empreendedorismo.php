<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Data\Treinamento\Materias\Empreendedorismo;

use Data\Treinamento\Materias\Materias;

class Empreendedorismo extends Materias
{


    public static function getDataClasses()
    {
        return [
            FailFast::class,
        ];
    }
}
