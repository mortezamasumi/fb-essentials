<?php

namespace Mortezamasumi\FbEssentials;

use Illuminate\Support\Facades\App;

class FbEssentials
{
    public function filamentShieldAddResource(string $class, array $permissions, bool $replace = false): void
    {
        if (App::environment('testing')) {
            return;
        }

        $policies = array_merge(
            $replace
                ? []
                : [
                    'viewAny',
                    'view',
                    'create',
                    'update',
                    'delete',
                    'restore',
                    'forceDelete',
                    'forceDeleteAny',
                    'restoreAny',
                    'replicate',
                    'reorder',
                ],
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
        if (App::environment('testing')) {
            return;
        }

        $current = config('filament-shield.resources.exclude') ?? [];

        config(['filament-shield.resources.exclude' => [
            ...$current,
            $class,
        ]]);
    }

    public function filamentShieldExcludePage(string $class): void
    {
        if (App::environment('testing')) {
            return;
        }

        $current = config('filament-shield.pages.exclude') ?? [];

        config(['filament-shield.pages.exclude' => [
            ...$current,
            $class,
        ]]);
    }

    public function filamentShieldExcludeWidget(string $class): void
    {
        if (App::environment('testing')) {
            return;
        }

        $current = config('filament-shield.widgets.exclude') ?? [];

        config(['filament-shield.widgets.exclude' => [
            ...$current,
            $class,
        ]]);
    }
}
