<?php

namespace Mortezamasumi\FbEssentials\Traits;

use Filament\Actions\Imports\Models\Import;

trait ImportCompletedNotificationBody
{
    use CompletedNotificationBody;

    public static function getCompletedNotificationBody(Import $import): string
    {
        return self::completedNotificationBody(
            successFa: 'بارگذاری انجام شد و ',
            successEn: 'Import has completed and ',
            successEnEnd: ' imported.',
            failedFa: 'و تعداد ',
            failedFaEnd: ' سطر دارای خطا بود و بارگذاری نشد',
            failedEn: ' failed to import.',
            successfulRows: $import->successful_rows,
            failedRowsCount: $import->getFailedRowsCount(),
        );
    }
}
