<?php

namespace Mortezamasumi\FbEssentials\Traits;

use Filament\Actions\Exports\Models\Export;

trait ExportCompletedNotificationBody
{
    use CompletedNotificationBody;

    public static function getCompletedNotificationBody(Export $export): string
    {
        return self::completedNotificationBody(
            successFa: 'برون برد انجام شد و ',
            successEn: 'Export has completed and ',
            successEnEnd: ' exported.',
            failedFa: 'و تعداد ',
            failedFaEnd: ' سطر دارای خطا بود و ایجاد نشد',
            failedEn: ' failed to export.',
            successfulRows: $export->successful_rows,
            failedRowsCount: $export->getFailedRowsCount(),
        );
    }
}
