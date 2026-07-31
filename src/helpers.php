<?php

use Mortezamasumi\FbEssentials\Facades\FbPersian;

if (! function_exists('__f_date')) {
    function __f_date(): string
    {
        return __('fb-essentials::fb-essentials.date_format.simple');
    }
}

if (! function_exists('__f_datetime')) {
    function __f_datetime(): string
    {
        return __('fb-essentials::fb-essentials.date_format.time_simple');
    }
}

if (! function_exists('__f_datefull')) {
    function __f_datefull(): string
    {
        return __('fb-essentials::fb-essentials.date_format.full');
    }
}

if (! function_exists('__f_datetimefull')) {
    function __f_datetimefull(): string
    {
        return __('fb-essentials::fb-essentials.date_format.time_full');
    }
}

if (! function_exists('__digit')) {
    function __digit(?string $string, ?string $forceLocale = null): string
    {
        return FbPersian::digit($string, $forceLocale);
    }
}

if (! function_exists('__jdate')) {
    function __jdate(?string $format, mixed $datetime = null, ?string $timezone = null, ?string $forceLocale = null): string
    {
        return FbPersian::jDate($format, $datetime, $timezone, $forceLocale);
    }
}

if (! function_exists('__jdatetime')) {
    function __jdatetime(?string $format, mixed $datetime = null, ?string $timezone = null, ?string $forceLocale = null): string
    {
        return FbPersian::jDateTime($format, $datetime, $timezone, $forceLocale);
    }
}
