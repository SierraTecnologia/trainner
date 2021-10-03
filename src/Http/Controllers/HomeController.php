<?php

namespace Trainner\Http\Controllers;

use Trainner\Services\TrainnerService;
use Illuminate\Support\Facades\Schema;
use Request;

class HomeController extends Controller
{
    protected $service;

    public function __construct(TrainnerService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        return view('trainner::dash.home');
    }
}
