<?php

use Illuminate\Database\Eloquent\Model;
use Mortezamasumi\FbEssentials\Traits\TranslatableUnicodeJson;

function callAsJson(object $model, array $value): string
{
    return (new ReflectionMethod($model, 'asJson'))->invoke($model, $value);
}

it('encodes json with unescaped unicode', function () {
    $model = new class extends Model
    {
        use TranslatableUnicodeJson;
    };

    $json = callAsJson($model, ['name' => 'محمدرضا']);

    expect($json)
        ->toContain('محمدرضا')
        ->not->toContain('\\u0645');
});

it('encodes plain ascii json correctly', function () {
    $model = new class extends Model
    {
        use TranslatableUnicodeJson;
    };

    $json = callAsJson($model, ['name' => 'hello']);

    expect($json)->toBe('{"name":"hello"}');
});

it('handles mixed persian and english text', function () {
    $model = new class extends Model
    {
        use TranslatableUnicodeJson;
    };

    $json = callAsJson($model, ['title' => 'سلام world']);

    expect($json)
        ->toContain('سلام')
        ->toContain('world');
});
