<?php

namespace Trainner\Http\Controllers\Admin;

use Trainner\Models\Conteudo;
use Pedreiro\CrudController;

class ConteudoController extends Controller
{
    use CrudController;

    public function __construct(Conteudo $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
