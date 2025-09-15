<?php

namespace Mortezamasumi\FbEssentials\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array arfaTOenDigits()
 * @method static array enTOfaDigits()
 * @method static array enarTOfaLetters()
 * @method static array enfaTOarLetters()
 * @method static array arTOfaLetters()
 * @method static array enTOarDigits()
 * @method static array persianLetters()
 * @method static array persianConvert()
 * @method static string faTOen(?string $string)
 * @method static string enTOfa(?string $string)
 * @method static string enarTOfa(?string $string)
 * @method static string enTOar(?string $string)
 * @method static string arTOfa(?string $string)
 * @method static string arfaTOen(?string $string)
 * @method static string enfaTOar(?string $string)
 * @method static string digit(?string $string, $forceLocale = null)
 * @method static string jDateTime(?string $format, $datetime = null, ?string $timezome = null, $forceLocale = null)
 * @method static string jDateTimeForceLocale(?string $format, $datetime = null, ?string $timezome = null, $forceLocale = null)
 *
 * @see \Mortezamasumi\FbEssentials\FbPersian
 */
class FbPersian extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Mortezamasumi\FbEssentials\FbPersian::class;
    }
}
