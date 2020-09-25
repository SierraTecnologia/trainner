<?php

namespace Trainner\Http\Controllers;

use Trainner\Services\TrainnerService;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    protected $service;

    public function __construct(TrainnerService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    public function index(Request $request)
    {
        return view('trainner::dash.home');
    }
}
