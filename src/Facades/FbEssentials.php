<?php

namespace Mortezamasumi\FbEssentials\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void filamentShieldAddResource(string $class, array $permissions, bool $replace)
 * @method static void filamentShieldExcludeResource(string $class)
 * @method static void filamentShieldExcludePage(string $class)
 * @method static void filamentShieldExcludeWidget(string $class)
 *
 * @see \Mortezamasumi\FbEssentials\FbEssentials
 */
class FbEssentials extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Mortezamasumi\FbEssentials\FbEssentials::class;
    }
}
