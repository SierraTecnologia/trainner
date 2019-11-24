<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Data\Treinamento\Data\ExplanandoConteudo;

use Data\Treinamento\Data\Data;

class ExplanandoConteudo extends Data
{
    public static function getDataClasses()
    {
        return array_merge(
            Pensadores\Pensadores::getDataClasses(),
            Books\Books::getDataClasses(),
        );
    }

}
