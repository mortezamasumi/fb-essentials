<?php

namespace Mortezamasumi\FbEssentials\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array<string, string> arfaTOenDigits()
 * @method static array<int, string> enTOfaDigits()
 * @method static array<int|string, string> enarTOfaLetters()
 * @method static array<int|string, string> enfaTOarLetters()
 * @method static array<string, string> arTOfaLetters()
 * @method static array<int, string> enTOarDigits()
 * @method static array<int, string> persianLetters()
 * @method static array<string, string> persianConvert()
 * @method static string faTOen(?string $string)
 * @method static string enTOfa(?string $string)
 * @method static string enarTOfa(?string $string)
 * @method static string enTOar(?string $string)
 * @method static string arTOfa(?string $string)
 * @method static string arfaTOen(?string $string)
 * @method static string enfaTOar(?string $string)
 * @method static string digit(?string $string, ?string $forceLocale = null)
 * @method static string jDate(?string $format, mixed $datetime = null, ?string $timezone = null, ?string $forceLocale = null)
 * @method static string jDateTime(?string $format, mixed $datetime = null, ?string $timezone = null, ?string $forceLocale = null)
 * @method static string jDateTimeForceLocale(?string $format, mixed $datetime = null, ?string $timezone = null, ?string $forceLocale = null)
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
