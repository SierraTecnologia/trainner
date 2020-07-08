<?php

namespace Data\Treinamento\Artigos\Filosofia;

use Population\Models\Identity\Digital\Sitio;
use Artista\Models\Video;

class Ti extends Filosofia
{
    
    public function run()
    {
        $this->recomendarTexto(
            'https://janynnegomes.wordpress.com/2017/01/05/a-importancia-do-github-e-do-stack-overflow/',
        );
    }   

}