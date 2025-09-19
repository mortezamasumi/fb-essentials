<?php

namespace Mortezamasumi\FbEssentials;

class FbEssentials
{
    public function filamentShieldAddResource(string $class, array $permissions, bool $replace = false): void
    {
        $policies = array_merge(
            $replace ? [] : config(['filament-shield.policies.methods']),
            $permissions,
        );

        $current = config('filament-shield.resources.manage') ?? [];

        config(['filament-shield.resources.manage' => [
            ...$current,
            $class => $policies,
        ]]);
    }

    public function filamentShieldExcludeResource(string $class): void
    {
        $current = config('filament-shield.resources.exclude') ?? [];

        config(['filament-shield.resources.exclude' => [
            ...$current,
            $class,
        ]]);
    }

    public function filamentShieldExcludePage(string $class): void
    {
        $current = config('filament-shield.pages.exclude') ?? [];

        config(['filament-shield.pages.exclude' => [
            ...$current,
            $class,
        ]]);
    }

    public function filamentShieldExcludeWidget(string $class): void
    {
        $current = config('filament-shield.widgets.exclude') ?? [];

        config(['filament-shield.widgets.exclude' => [
            ...$current,
            $class,
        ]]);
    }
}
