<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Data\Treinamento\Data;

class Data
{

    public static function getDataClasses()
    {
        return array_merge(
            ExplanandoConteudo\ExplanandoConteudo::getDataClasses(),
        );
    }
    

}
