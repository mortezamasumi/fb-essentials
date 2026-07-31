<?php

namespace Mortezamasumi\FbEssentials;

use Filament\Schemas\Components\Form;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;
use Livewire\Features\SupportTesting\Testable;
use Mortezamasumi\FbEssentials\Macros\ExportMacroServiceProvider;
use Mortezamasumi\FbEssentials\Macros\FormMacroServiceProvider;
use Mortezamasumi\FbEssentials\Macros\InfolistMacroServiceProvider;
use Mortezamasumi\FbEssentials\Macros\PsortMacroServiceProvider;
use Mortezamasumi\FbEssentials\Macros\TableMacroServiceProvider;
use Mortezamasumi\FbEssentials\Testing\TestsFbEssentials;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
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
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile();
            })
            ->hasTranslations()
            ->hasViews()
            ->hasAssets()
            ->hasConfigFile();
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
        Route::get('/fb-essentials-assets/{filename}', function ($filename) {
            $publishedPath = public_path('vendor/fb-essentials/images/'.$filename);
            if (file_exists($publishedPath)) {
                return Response::file($publishedPath);
            }

            $packagePath = __DIR__.'/../resources/dist/images/'.$filename;
            if (! file_exists($packagePath)) {
                abort(404);
            }

            return Response::file($packagePath);
        })->name('fb-essentials.assets');

        Form::configureUsing(function (Form $form) {
            $form->extraAttributes(['novalidate' => true]);
        });

        Testable::mixin(new TestsFbEssentials);
    }
}
