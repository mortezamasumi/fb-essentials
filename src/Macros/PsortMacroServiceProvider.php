<?php

namespace Mortezamasumi\FbEssentials\Macros;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Mortezamasumi\FbEssentials\Facades\FbPersian;

/**
 * Interface declaring Collection psort macro for IDE support
 *
 * @method static Column psort(?string $forceLocale) current locale apply
 */
interface PsortMacrosInterface {}

class PsortMacroServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /**
         * Sorts a collection by a given field or by its values.
         * Allows for a custom callback to be applied to the values before comparison.
         *
         * @param string|null $field The key to sort by. If null, sorts by the item value itself.
         * @param bool $ascending True for ascending, false for descending order.
         * @param callable|null $callback A callback to apply to each value before comparison.
         * @return \Illuminate\Support\Collection
         */
        Collection::macro('pSort', function (?string $field = null, bool $ascending = true, ?callable $callback = null) {
            /** @var Collection $this */
            $items = $this->all();

            usort($items, function ($a, $b) use ($field, $ascending, $callback) {
                $valueA = $field ? data_get($a, $field) : $a;
                $valueB = $field ? data_get($b, $field) : $b;

                if ($callback) {
                    $valueA = $callback($valueA);
                    $valueB = $callback($valueB);
                } else {
                    $valueA = strtr($valueA, FbPersian::persianConvert());
                    $valueB = strtr($valueB, FbPersian::persianConvert());
                }

                $result = $valueA <=> $valueB;

                return $ascending ? $result : -$result;
            });

            return new static($items);
        });

        TextColumn::mixin(new class implements PsortMacrosInterface {});
    }
}
