<?php

namespace Mortezamasumi\FbEssentials\Traits;

use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

trait ExportCompletedNotificationBody
{
    /**
     * Get export completed notification body
     *
     * @param  Export  $export
     * @return string
     */
    public static function getCompletedNotificationBody(Export $export): string
    {
        if (App::getLocale() === 'fa') {
            $body = 'برون برد انجام شد و '
                .Number::format(number: $export->successful_rows, locale: App::getLocale())
                .' سطر ایجاد شد';

            if ($failedRowsCount = $export->getFailedRowsCount()) {
                $body .= 'و تعداد '
                    .Number::format(number: $failedRowsCount, locale: App::getLocale())
                    .' سطر دارای خطا بود و ایجاد نشد';
            }
        } else {
            $body = 'Export has completed and '
                .number_format($export->successful_rows)
                .' '
                .Str::plural('row', $export->successful_rows)
                .' exported.';

            if ($failedRowsCount = $export->getFailedRowsCount()) {
                $body .= ', '
                    .number_format($failedRowsCount)
                    .' '
                    .Str::plural('row', $failedRowsCount)
                    .' failed to export.';
            }
        }

        return $body;
    }
}
