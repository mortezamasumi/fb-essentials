<?php

namespace Mortezamasumi\FbEssentials;

use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use BezhanSalleh\LanguageSwitch\Http\Middleware\SwitchLanguageLocale;
use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use Filament\Contracts\Plugin;
use Filament\FontProviders\SpatieGoogleFontProvider;
use Filament\Panel;
use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;
use pxlrbt\FilamentEnvironmentIndicator\EnvironmentIndicatorPlugin;

class FbEssentialsPlugin implements Plugin
{
    public function getId(): string
    {
        return 'fb-essentials';
    }

    public function register(Panel $panel): void
    {
        if (config('fb-essentials.has_language_switcher')) {
            $panel->middleware([
                SwitchLanguageLocale::class,
            ]);
        }

        if (config('fb-essentials.has_translatable')) {
            $languages = explode(',', config('fb-essentials.used_languages'));

            $panel->plugin(SpatieTranslatablePlugin::make()->defaultLocales($languages));
        }

        if (config('fb-essentials.has_shield')) {
            $panel->plugin(
                FilamentShieldPlugin::make()
                    ->navigationGroup(fn () => __('fb-user::fb-user.navigation.group'))
                    ->navigationSort(config('fb-essentials.shield_resource_sort'))
            );
        }

        if (config('fb-essentials.has_environment_indicator')) {
            $panel->plugin(EnvironmentIndicatorPlugin::make());
        }

        if (config('fb-essentials.has_vazirmatn_font')) {
            config(['google-fonts.fonts.default' => 'https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100;200;300;400;500;600;700;800;900']);

            $panel->font('Vazirmatn', provider: SpatieGoogleFontProvider::class);
        }

        $panel
            ->resourceCreatePageRedirect('index')
            ->resourceEditPageRedirect('index')
            ->spa(config('fb-essentials.app_as_spa'));
    }

    public function boot(Panel $panel): void
    {
        if (config('fb-essentials.has_language_switcher')) {
            $languages = explode(',', config('fb-essentials.used_languages'));

            LanguageSwitch::configureUsing(function (LanguageSwitch $switch) use ($languages) {
                $switch->locales($languages);
            });
        }
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
