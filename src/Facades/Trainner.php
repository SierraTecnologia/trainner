<?php

namespace Trainner\Facades;

use Illuminate\Support\Facades\Facade;

class Trainner extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'trainner';
    }
}
