<?php

namespace Mortezamasumi\FbEssentials\Tests\Services;

use Filament\Actions\ExportAction;
use Filament\Pages\Page;

class PostsExport extends Page
{
    public function getHeaderActions(): array
    {
        return [
            ExportAction::make('export')
                ->exporter(PostExporter::class),
        ];
    }
}
