<?php

namespace Mortezamasumi\FbEssentials\Assets;

use Filament\Support\Assets\Asset;

class Images extends Asset
{
    public function getPublicPath(): string
    {
        // $path = config('filament.assets_path', '');
        // dd($path);

        // return ltrim("{$path}/css/{$this->getPackage()}/{$this->getId()}.css", '/');

        return dd(public_path('images/mortezamasumi/fb-essentials'));
    }
}
