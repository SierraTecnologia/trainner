<?php

namespace Trainner\Http\Controllers\Painel;

use Trainner\Models\Trainner;
use Pedreiro\CrudController;

class TrainnerController extends Controller
{
    use CrudController;

    public function __construct(Trainner $model)
    {
        $this->model = $model;
        parent::__construct();
    }
}
