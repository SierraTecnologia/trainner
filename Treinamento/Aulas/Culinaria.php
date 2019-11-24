<?php
/**
 * Rotinas de Inclusão de Dados
 */

namespace Data\Treinamento\Aulas;

class Culinaria extends Aulas
{
    public $sitec = false;

    public function run()
    {
        $this->cozinha();
        $this->armazenamento();
        $this->dicas();
    }

    public function cozinha()
    {
        // Video::firstOrCreate([
        //     'name' => 'Métodos de Coccao',
        //     'url' => 'https://www.youtube.com/watch?v=XFbvylsLAno',
        // ]);
    }

    public function armazenamento()
    {

        
    }

    public function dicas()
    {
        
    }


}
