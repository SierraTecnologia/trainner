<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Data\Treinamento\Tecnicas\Hacker;

use Data\Treinamento\Tecnicas\Tecnicas;

class Hacker extends Tecnicas
{


    public static function getDataClasses()
    {
        return [
            GoogleHacking::class,
        ];
    }
}
