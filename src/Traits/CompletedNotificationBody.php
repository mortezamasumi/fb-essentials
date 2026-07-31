<?php

namespace Mortezamasumi\FbEssentials\Traits;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

trait CompletedNotificationBody
{
    private static function completedNotificationBody(
        string $successFa,
        string $successEn,
        string $successEnEnd,
        string $failedFa,
        string $failedFaEnd,
        string $failedEn,
        int $successfulRows,
        ?int $failedRowsCount,
    ): string {
        if (App::getLocale() === 'fa') {
            $body = $successFa
                .Number::format(number: $successfulRows, locale: App::getLocale())
                .' سطر ایجاد شد';

            if ($failedRowsCount) {
                $body .= $failedFa
                    .Number::format(number: $failedRowsCount, locale: App::getLocale())
                    .$failedFaEnd;
            }
        } else {
            $body = $successEn
                .number_format($successfulRows)
                .' '
                .Str::plural('row', $successfulRows)
                .$successEnEnd;

            if ($failedRowsCount) {
                $body .= ', '
                    .number_format($failedRowsCount)
                    .' '
                    .Str::plural('row', $failedRowsCount)
                    .$failedEn;
            }
        }

        return $body;
    }
}
