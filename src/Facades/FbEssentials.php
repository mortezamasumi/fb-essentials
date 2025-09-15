<?php

namespace Mortezamasumi\FbEssentials\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mortezamasumi\FbEssentials\FbEssentials
 */
class FbEssentials extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Mortezamasumi\FbEssentials\FbEssentials::class;
    }
}
