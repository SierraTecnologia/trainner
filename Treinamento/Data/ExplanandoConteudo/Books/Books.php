<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Data\Treinamento\Data\ExplanandoConteudo\Books;

use Data\Treinamento\Data\ExplanandoConteudo\ExplanandoConteudo;

class Books extends ExplanandoConteudo
{
    public static function getDataClasses()
    {
        return [
            Gestao::class,
        ];
    }

}
