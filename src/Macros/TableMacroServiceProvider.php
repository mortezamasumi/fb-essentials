<?php

namespace Mortezamasumi\FbEssentials\Macros;

use Closure;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Mortezamasumi\FbPersian\Facades\FbPersian;

/**
 * Interface declaring Table macros for IDE support
 *
 * @method static Column jDate(string|Closure|null $Tableat, ?string $timezone) jDate apply
 * @method static Column jDateTime(string|Closure|null $Tableat, ?string $timezone, bool|Closure $onlyDate) jDateTime apply
 * @method static Column localeDigit(?string $forceLocale) current locale apply
 */
interface TableMacrosInterface {}

class TableMacroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        TextColumn::macro('jDate', function (string|Closure|null $format = null, ?string $timezone = null, ?string $forceLocale = null): TextColumn {
            /** @var TextColumn $this */
            $this->jDateTime($format, $timezone, $forceLocale, true);

            return $this;
        });

        TextColumn::macro('jDateTime', function (string|Closure|null $format = null, ?string $timezone = null, ?string $forceLocale = null, bool|Closure $onlyDate = false): TextColumn {
            /** @var TextColumn $this */
            $this->formatStateUsing(static function (TextColumn $column, ?Model $record, $state) use ($format, $timezone, $forceLocale, $onlyDate): ?string {
                if (blank($state)) {
                    return null;
                }

                $format = $column->evaluate($format, ['record' => $record, 'state' => $state]);
                $onlyDate = $column->evaluate($onlyDate, ['record' => $record, 'state' => $state]);
                $format ??= ($onlyDate ? __('fb-persian::fb-persian.date_format.simple') : __('fb-persian::fb-persian.date_format.time_simple'));

                return FbPersian::jDateTime($format, $state, $timezone, $forceLocale);
            });

            return $this;
        });

        TextColumn::macro('localeDigit', function (?string $forceLocale = null): TextColumn {
            /** @var TextColumn $this */
            $this->formatStateUsing(static fn (mixed $state) => in_array(gettype($state), ['integer', 'double', 'string']) ? FbPersian::digit($state, $forceLocale) : $state);

            return $this;
        });

        TextColumn::mixin(new class implements TableMacrosInterface {});
    }
}
