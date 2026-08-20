<?php

namespace Mortezamasumi\FbEssentials;

use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use BezhanSalleh\LanguageSwitch\Enums\TriggerStyle;
use BezhanSalleh\LanguageSwitch\Http\Middleware\SwitchLanguageLocale;
use BezhanSalleh\LanguageSwitch\LanguageSwitch;
use Filament\Contracts\Plugin;
use Filament\FontProviders\GoogleFontProvider;
use Filament\Panel;
use LaraZeus\SpatieTranslatable\SpatieTranslatablePlugin;
use pxlrbt\FilamentEnvironmentIndicator\EnvironmentIndicatorPlugin;

class FbEssentialsPlugin implements Plugin
{
    protected ?bool $hasLanguageSwitcher = null;

    protected ?bool $hasTranslatable = null;

    protected ?bool $hasShield = null;

    protected ?bool $hasEnvironmentIndicator = null;

    protected ?bool $hasVazirmatnFont = null;

    protected ?bool $appAsSpa = null;

    public function getId(): string
    {
        return 'fb-essentials';
    }

    public function register(Panel $panel): void
    {
        if ($this->should('has_language_switcher')) {
            $panel->middleware([
                SwitchLanguageLocale::class,
            ]);
        }

        if ($this->should('has_translatable')) {
            $panel->plugin(SpatieTranslatablePlugin::make()->defaultLocales(config('fb-essentials.used_languages')));
        }

        if ($this->should('has_shield')) {
            $panel->plugin(
                FilamentShieldPlugin::make()
                    ->navigationGroup(fn () => __('fb-user::fb-user.navigation.group'))
                    ->navigationSort(config('fb-essentials.shield_resource_sort'))
            );
        }

        if ($this->should('has_environment_indicator')) {
            $panel->plugin(EnvironmentIndicatorPlugin::make());
        }

        if ($this->should('has_vazirmatn_font')) {
            config(['google-fonts.fonts.default' => 'https://fonts.googleapis.com/css2?family=Vazirmatn:wght@100;200;300;400;500;600;700;800;900']);

            $panel->font('Vazirmatn', provider: GoogleFontProvider::class);
        }

        $panel
            ->resourceCreatePageRedirect('index')
            ->resourceEditPageRedirect('index')
            ->spa($this->should('app_as_spa'));
    }

    public function boot(Panel $panel): void
    {
        if ($this->should('has_language_switcher')) {
            LanguageSwitch::configureUsing(function (LanguageSwitch $switch) {
                $switch
                    ->locales(config('fb-essentials.used_languages'))
                    ->trigger(style: TriggerStyle::IconLabel);
            });
        }
    }

    public function languageSwitcher(bool $enabled): static
    {
        $this->hasLanguageSwitcher = $enabled;

        return $this;
    }

    public function translatable(bool $enabled): static
    {
        $this->hasTranslatable = $enabled;

        return $this;
    }

    public function shield(bool $enabled): static
    {
        $this->hasShield = $enabled;

        return $this;
    }

    public function environmentIndicator(bool $enabled): static
    {
        $this->hasEnvironmentIndicator = $enabled;

        return $this;
    }

    public function vazirmatnFont(bool $enabled): static
    {
        $this->hasVazirmatnFont = $enabled;

        return $this;
    }

    public function spa(bool $enabled): static
    {
        $this->appAsSpa = $enabled;

        return $this;
    }

    protected function should(string $key): bool
    {
        return match ($key) {
            'has_language_switcher' => $this->hasLanguageSwitcher ?? config('fb-essentials.has_language_switcher'),
            'has_translatable' => $this->hasTranslatable ?? config('fb-essentials.has_translatable'),
            'has_shield' => $this->hasShield ?? config('fb-essentials.has_shield'),
            'has_environment_indicator' => $this->hasEnvironmentIndicator ?? config('fb-essentials.has_environment_indicator'),
            'has_vazirmatn_font' => $this->hasVazirmatnFont ?? config('fb-essentials.has_vazirmatn_font'),
            'app_as_spa' => $this->appAsSpa ?? config('fb-essentials.app_as_spa'),
            default => (bool) config("fb-essentials.{$key}"),
        };
    }

    public static function make(): self
    {
        return new self;
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
