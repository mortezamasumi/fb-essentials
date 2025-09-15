<?php

namespace Mortezamasumi\FbEssentials\Traits;

use Illuminate\Database\Eloquent\Casts\Json;

trait TranslatableUnicodeJson
{
    /**
     * Encode the given value as JSON.
     *
     * @param  mixed  $value
     * @param  int  $flags
     * @return string
     */
    protected function asJson($value, $flags = 0): string
    {
        return Json::encode($value, JSON_UNESCAPED_UNICODE | $flags);
    }
}
