<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Data\Treinamento\Data\ExplanandoConteudo\Pensadores;

use Data\Treinamento\Data\ExplanandoConteudo\ExplanandoConteudo;

class Pensadores extends ExplanandoConteudo
{
    public static function getDataClasses()
    {
        return [
            Economia::class,
        ];
    }

}
