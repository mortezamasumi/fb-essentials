<?php

namespace Mortezamasumi\FbEssentials\Macros;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Arr;
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

            // Type 4: Eloquent Collection
            if ($this instanceof EloquentCollection) {
                return $this;
            }

            // Type 2: Dictionary - collect(['111' => 'a', '222' => 'b']);
            if (Arr::isAssoc($this->toArray())) {
                $sortedItems = $this->all();

                uasort($sortedItems, function ($a, $b) use ($ascending, $callback) {
                    if ($callback) {
                        $valueA = $callback($a);
                        $valueB = $callback($b);
                    } else {
                        $valueA = strtr((string) $a, FbPersian::persianConvert());
                        $valueB = strtr((string) $b, FbPersian::persianConvert());
                    }

                    $result = $valueA <=> $valueB;

                    return $ascending ? $result : -$result;
                });

                return new static($sortedItems);
            }

            // Type 3: List of Structs - collect([['key' => '111', 'value' => 'a'], ['key' => '222', 'value' => 'b']])
            $firstItem = $this->first();

            if ($this->isNotEmpty() && (is_array($firstItem) || is_object($firstItem))) {
                $sortedItems = $this->all();

                usort($sortedItems, function ($a, $b) use ($field, $ascending, $callback) {
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

                return new static($sortedItems);
            }

            // Type 1: Simple - collect(['a', 'b', 'c'])
            $sortedItems = $this->all();

            usort($sortedItems, function ($a, $b) use ($ascending, $callback) {
                if ($callback) {
                    $valueA = $callback($a);
                    $valueB = $callback($b);
                } else {
                    $valueA = strtr((string) $a, FbPersian::persianConvert());
                    $valueB = strtr((string) $b, FbPersian::persianConvert());
                }

                $result = $valueA <=> $valueB;

                return $ascending ? $result : -$result;
            });

            return new static($sortedItems);
        });

        TextColumn::mixin(new class implements PsortMacrosInterface {});
    }
}
