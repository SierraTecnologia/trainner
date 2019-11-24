<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Data\Treinamento\Artigos\Empreendedorismo;

use Data\Treinamento\Artigos\Artigos;

class Empreendedorismo extends Artigos
{


    public static function getDataClasses()
    {
        return [
            FailFast::class,
        ];
    }
}
