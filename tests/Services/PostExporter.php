<?php

namespace Mortezamasumi\FbEssentials\Tests\Services;

use Filament\Actions\Exports\Models\Export;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Mortezamasumi\FbEssentials\Traits\ExportCompletedNotificationBody;

class PostExporter extends Exporter
{
    use ExportCompletedNotificationBody;

    protected static ?string $model = Post::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('title1')->localeDigit(),
            ExportColumn::make('title2'),
            ExportColumn::make('date1')->jDate(),
            ExportColumn::make('date2')->jDateTime(),
        ];
    }
}
