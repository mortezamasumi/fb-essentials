<?php

namespace Mortezamasumi\FbEssentials\Tests\Services;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\Action;
use Filament\Actions\ExportAction;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Contracts\HasSchemas;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class PostsExport extends Component implements HasActions, HasSchemas
{
    use InteractsWithActions;
    use InteractsWithSchemas;

    public function exportAction(): Action
    {
        return ExportAction::make('export')
            ->exporter(PostExporter::class);
    }

    public function render(): View
    {
        return view('posts-export');
    }
}
