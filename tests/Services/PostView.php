<?php

namespace Mortezamasumi\FbEssentials\Tests\Services;

use Filament\Infolists\Components\TextEntry;
use Filament\Pages\Page;
use Filament\Schemas\Schema;

class PostView extends Page
{
    public Post $record;

    public function mount(Post $record): void
    {
        $this->record = $record;
    }

    public function content(Schema $schema): Schema
    {
        return $schema
            ->record($this->record)
            ->components([
                TextEntry::make('title1')->localeDigit(),
                TextEntry::make('title2'),
                TextEntry::make('date1')->jDate(),
                TextEntry::make('date2')->jDateTime(),
            ]);
    }
}
