<?php

namespace Mortezamasumi\FbEssentials\Macros;

use Closure;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Mortezamasumi\FbEssentials\Facades\FbPersian;

/**
 * Interface declaring Form macros for IDE support
 *
 * @method static Component jDate(string|Closure|null $format, ?string $timezone) jDate apply
 * @method static Component jDateTime(string|Closure|null $format, ?string $timezone, bool|Closure $onlyDate) jDateTime apply
 * @method static Component toEN() to en apply
 * @method static Component toAF() to fa apply
 */
interface FormMacrosInterface {}

class FormMacroServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        TextInput::macro('toEN', function (): TextInput {
            /** @var TextInput $this */
            $this->dehydrateStateUsing(fn (?string $state): string => FbPersian::arfaTOen($state));

            return $this;
        });

        TextInput::macro('toFA', function (): TextInput {
            /** @var TextInput $this */
            $this->dehydrateStateUsing(fn (?string $state): string => FbPersian::enarTOfa($state));

            return $this;
        });

        DatePicker::macro('jDate', function (string|Closure|null $format = null, ?string $timezone = null): DatePicker {
            /** @var DatePicker $this */
            $this->jDateTime($format, $timezone, true);

            return $this;
        });

        DateTimePicker::macro('jDateTime', function (string|Closure|null $format = null, ?string $timezone = null, bool|Closure $onlyDate = false): DateTimePicker {
            /** @var DateTimePicker $this */
            if (App::getLocale() === 'fa') {
                $this->jalali(weekdaysShort: true)->firstDayOfWeek(6);
            } else {
                $this->native(false);
            }

            $this->displayFormat(static function (DateTimePicker $component, ?Model $record, $state) use ($format, $onlyDate): string {
                $format = $component->evaluate($format, ['record' => $record, 'state' => $state]);
                $onlyDate = $component->evaluate($onlyDate, ['record' => $record, 'state' => $state]);
                $format ??= ($onlyDate ? __('fb-essentials::fb-essentials.date_format.simple') : __('fb-essentials::fb-essentials.date_format.time_simple'));

                return $format;
            });

            return $this;
        });

        TextInput::mixin(new class implements FormMacrosInterface {});
    }
}
