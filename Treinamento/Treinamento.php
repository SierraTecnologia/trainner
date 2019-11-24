<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Data\Treinamento;

class Treinamento
{

    public static function getDataClasses()
    {
        return array_merge(
            Data\Data::getDataClasses(),
            Ciencias\Ciencias::getDataClasses(),
            Materias\Materias::getDataClasses(),
            Tecnicas\Tecnicas::getDataClasses(),
            Aulas\Aulas::getDataClasses(),
            Artigos\Artigos::getDataClasses(),
        );
    }

    public function addTexto($url)
    {
        // @todo Fazer
        return true;
    }

    public function recomendarTexto($url)
    {
        // @todo Fazer
        return true;
    }
}
