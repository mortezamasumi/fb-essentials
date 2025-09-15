<?php

namespace Mortezamasumi\FbEssentials;

use Livewire\Features\SupportTesting\Testable;
use Mortezamasumi\FbEssentials\Macros\ExportMacroServiceProvider;
use Mortezamasumi\FbEssentials\Macros\FormMacroServiceProvider;
use Mortezamasumi\FbEssentials\Macros\InfolistMacroServiceProvider;
use Mortezamasumi\FbEssentials\Macros\PsortMacroServiceProvider;
use Mortezamasumi\FbEssentials\Macros\TableMacroServiceProvider;
use Mortezamasumi\FbEssentials\Testing\TestsFbEssentials;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FbEssentialsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'fb-essentials';
    public static string $viewNamespace = 'fb-essentials';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(static::$name)
            ->hasTranslations()
            ->hasViews();
    }

    public function packageRegistered(): void
    {
        $this->app->register(ExportMacroServiceProvider::class);
        $this->app->register(FormMacroServiceProvider::class);
        $this->app->register(InfolistMacroServiceProvider::class);
        $this->app->register(TableMacroServiceProvider::class);
        $this->app->register(PsortMacroServiceProvider::class);
    }

    public function packageBooted(): void
    {
        Testable::mixin(new TestsFbEssentials);
    }
}
