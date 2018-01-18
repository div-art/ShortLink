<?php

namespace DivArt\ShortLink\Facades;

use Illuminate\Support\Facades\Facade;

class ShortLink extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'shortLink';
    }
}