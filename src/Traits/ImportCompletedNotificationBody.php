<?php

namespace Mortezamasumi\FbEssentials\Traits;

use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

trait ImportCompletedNotificationBody
{
    /**
     * Get import completed notification body
     *
     * @param  Import  $import
     * @return string
     */
    public static function getCompletedNotificationBody(Import $import): string
    {
        if (App::getLocale() === 'fa') {
            $body = 'بارگذاری انجام شد و '
                .Number::format(number: $import->successful_rows, locale: App::getLocale())
                .' سطر ایجاد شد';

            if ($failedRowsCount = $import->getFailedRowsCount()) {
                $body .= 'و تعداد '
                    .Number::format(number: $failedRowsCount, locale: App::getLocale())
                    .' سطر دارای خطا بود و بارگذاری نشد';
            }
        } else {
            $body = 'Import has completed and '
                .number_format($import->successful_rows)
                .' '
                .Str::plural('row', $import->successful_rows)
                .' imported.';

            if ($failedRowsCount = $import->getFailedRowsCount()) {
                $body .= ', '
                    .number_format($failedRowsCount)
                    .' '
                    .Str::plural('row', $failedRowsCount)
                    .' failed to import.';
            }
        }

        return $body;
    }
}
